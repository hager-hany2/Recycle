import os
import re
import json
import random
import numpy as np
import pandas as pd
from flask import Flask, request, jsonify
import tensorflow as tf
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.text import Tokenizer
from tensorflow.keras.preprocessing.sequence import pad_sequences
from sklearn.preprocessing import LabelEncoder

app = Flask(__name__)

class ChatbotConfig:
    def __init__(self, data_path='data.json', model_path='arabic.keras'):
        try:
            with open(data_path, 'r', encoding='utf-8') as f:
                self.data = json.load(f)
        except (FileNotFoundError, json.JSONDecodeError) as e:
            raise Exception(f"Error loading data file: {e}")

        self.last_label = None
        self._prepare_dataframe()
        self._prepare_tokenizer()
        self._encode_labels()
        self._load_or_train_model(model_path)

    def _prepare_dataframe(self):
        dic = {"label": [], "patterns": [], "responses": []}
        for example in self.data.get('data', []):
            for pattern in example.get('patterns', []):
                dic['patterns'].append(self._normalize_arabic(pattern))
                dic['label'].append(example.get('label', 'unknown'))
                dic['responses'].append(example.get('responses', []))
        self.df = pd.DataFrame(dic)

    def _prepare_tokenizer(self):
        self.tokenizer = Tokenizer(lower=True)
        self.tokenizer.fit_on_texts(self.df['patterns'])
        ptrn2seq = self.tokenizer.texts_to_sequences(self.df['patterns'])
        self.X = pad_sequences(ptrn2seq, padding='post')

    def _encode_labels(self):
        self.lbl_enc = LabelEncoder()
        self.y = self.lbl_enc.fit_transform(self.df['label'])

    def _load_or_train_model(self, model_path):
        self.vocab_size = len(self.tokenizer.word_index) + 1
        if os.path.exists(model_path):
            try:
                self.model = load_model(model_path)
            except Exception as e:
                raise Exception(f"Error loading model: {e}")
        else:
            self.model = self._build_model()
            self._train_model()
            self.model.save(model_path)

    def _build_model(self):
        model = tf.keras.Sequential([
            tf.keras.layers.Embedding(input_dim=self.vocab_size, output_dim=128, input_length=self.X.shape[1]),
            tf.keras.layers.Bidirectional(tf.keras.layers.LSTM(64, return_sequences=True)),
            tf.keras.layers.LayerNormalization(),
            tf.keras.layers.Bidirectional(tf.keras.layers.LSTM(64)),
            tf.keras.layers.Dense(128, activation='relu'),
            tf.keras.layers.Dropout(0.5),
            tf.keras.layers.Dense(len(np.unique(self.y)), activation='softmax')
        ])
        model.compile(optimizer='adam', loss='sparse_categorical_crossentropy', metrics=['accuracy'])
        return model

    def _train_model(self):
        early_stopping = tf.keras.callbacks.EarlyStopping(monitor='val_loss', patience=3, restore_best_weights=True)
        self.model.fit(
            self.X, self.y, batch_size=16, epochs=50, validation_split=0.2, callbacks=[early_stopping]
        )

    def _normalize_arabic(self, text):
        text = re.sub(r'[إأآا]', 'ا', text)
        text = re.sub(r'ى', 'ي', text)
        text = re.sub(r'ؤ', 'و', text)
        text = re.sub(r'ة', 'ه', text)
        text = re.sub(r'ئ', 'ي', text)
        text = re.sub(r'[ً-ْ]', '', text)  # Remove diacritics
        text = re.sub(r'[^؀-ۿ\s]', '', text)  # Keep only Arabic letters and spaces
        return text.strip()

    def predict_response(self, user_input):
        cleaned_input = self._normalize_arabic(user_input.lower())
        sequence = self.tokenizer.texts_to_sequences([cleaned_input])
        padded_sequence = pad_sequences(sequence, padding='post', maxlen=self.X.shape[1])
        y_pred = self.model.predict(padded_sequence)
        y_pred_class = y_pred.argmax()
        tag = self.lbl_enc.inverse_transform([y_pred_class])[0]

        if tag == "unknown":
            return "هذا السؤال خارج نطاق تخصصي. ممكن تسألني في حاجه تخص إعادة التدوير وأنا أساعدك."

        responses = self.df.loc[self.df['label'] == tag, 'responses'].values[0]
        return random.choice(responses) if responses else "لا أملك إجابة لهذا السؤال حالياً."

chatbot = ChatbotConfig()

@app.route('/chat', methods=['POST'])
def chat():
    data = request.get_json()
    user_message = data.get('message', '').strip()
    if not user_message:
        return jsonify({"response": "يرجى إدخال رسالة صحيحة."}), 400

    response = chatbot.predict_response(user_message)
    return jsonify({"response": response})

@app.route('/health', methods=['GET'])
def health_check():
    return jsonify({"status": "healthy"})

if __name__ == '__main__':
    app.run(debug=False, host='0.0.0.0', port=5000)
 