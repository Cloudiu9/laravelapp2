import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import RecognizeImageForm from './recognize-image'; 

ReactDOM.render(
  <React.StrictMode>
    <App />
    <RecognizeImageForm />
  </React.StrictMode>,
  document.getElementById('react-app')
);

