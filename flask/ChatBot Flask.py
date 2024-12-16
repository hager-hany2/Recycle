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

# Load configuration and model
class ChatbotConfig:
    def __init__(self, data_path='data.json', model_path='model.keras'):
        # Load intents data
        with open(data_path, 'r') as f:
            self.data = json.load(f)
        
        # Prepare DataFrame
        dic = {"tag":[], "patterns":[], "responses":[]}
        for example in self.data['intents']:
            for pattern in example['patterns']:
                dic['patterns'].append(pattern)
                dic['tag'].append(example['tag'])
                dic['responses'].append(example['responses'])
        
        self.df = pd.DataFrame.from_dict(dic)
        
        # Tokenization
        self.tokenizer = Tokenizer(lower=True, split=' ')
        self.tokenizer.fit_on_texts(self.df['patterns'])
        
        # Padding and Encoding
        ptrn2seq = self.tokenizer.texts_to_sequences(self.df['patterns'])
        self.X = pad_sequences(ptrn2seq, padding='post')
        
        # Label Encoding
        self.lbl_enc = LabelEncoder()
        self.y = self.lbl_enc.fit_transform(self.df['tag'])
        
        # Load or Retrain Model
        self.vocab_size = min(len(self.tokenizer.word_index) + 1, 1000)
        
        if os.path.exists(model_path):
            self.model = load_model(model_path)
        else:
            self.model = self._build_model()
            self._train_model()
            self.model.save(model_path)
    
    def _build_model(self):
        model = tf.keras.Sequential([
            tf.keras.layers.Input(shape=(self.X.shape[1],)),
            tf.keras.layers.Embedding(input_dim=self.vocab_size, output_dim=100),
            tf.keras.layers.LSTM(32, return_sequences=True),
            tf.keras.layers.LayerNormalization(),
            tf.keras.layers.LSTM(32, return_sequences=True),
            tf.keras.layers.LayerNormalization(),
            tf.keras.layers.LSTM(32),
            tf.keras.layers.LayerNormalization(),
            tf.keras.layers.Dense(128, activation="relu"),
            tf.keras.layers.LayerNormalization(),
            tf.keras.layers.Dropout(0.2),
            tf.keras.layers.Dense(len(np.unique(self.y)), activation="softmax")
        ])
        model.compile(optimizer='adam', 
                      loss="sparse_categorical_crossentropy", 
                      metrics=['accuracy'])
        return model
    
    def _train_model(self):
        early_stopping = tf.keras.callbacks.EarlyStopping(
            monitor='accuracy', 
            patience=3
        )
        self.model.fit(
            x=self.X,
            y=self.y,
            batch_size=10,
            callbacks=[early_stopping],
            epochs=100
        )
    
    def predict_response(self, user_input):
        # Preprocess input
        text = []
        txt = re.sub('[^a-zA-Z\']', ' ', user_input)
        txt = txt.lower()
        txt = txt.split()
        txt = " ".join(txt)
        text.append(txt)

        # Convert to sequence
        x_test = self.tokenizer.texts_to_sequences(text)
        x_test = np.array(x_test).squeeze()
        x_test = pad_sequences([x_test], padding='post', maxlen=self.X.shape[1])

        # Predict
        y_pred = self.model.predict(x_test)
        y_pred = y_pred.argmax()
        tag = self.lbl_enc.inverse_transform([y_pred])[0]

        # Get responses for the predicted tag
        responses = self.df[self.df['tag'] == tag]['responses'].values[0]
        return random.choice(responses)

# Initialize chatbot
chatbot = ChatbotConfig()

@app.route('/chat', methods=['POST'])
def chat():
    """
    API endpoint for chatbot interaction
    
    Expected JSON input:
    {
        "message": "User's input message"
    }
    
    Returns JSON response:
    {
        "response": "Chatbot's response"
    }
    """
    data = request.get_json()
    user_message = data.get('message', '')
    
    if not user_message:
        return jsonify({"response": "Please provide a message"}), 400
    
    try:
        bot_response = chatbot.predict_response(user_message)
        return jsonify({"response": bot_response})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/health', methods=['GET'])
def health_check():
    """Simple health check endpoint"""
    return jsonify({"status": "healthy"})

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)