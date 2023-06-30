import React, { useState } from 'react';
import axios from 'axios';

const Chatbot: React.FC = () => {
  const [inputValue, setInputValue] = useState('');

  const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setInputValue(event.target.value);
  };

  const handleButtonClick = () => {
    const value = inputValue.trim();
    if (value === '') return;

    const contentBox = document.getElementById('content-box');
    const chatbox = document.createElement('div');
    chatbox.className = 'mb-2';

    const floatRight = document.createElement('div');
    floatRight.className = 'float-right px-3 py-2';
    floatRight.style.cssText =
      'width: 270px; float: right; margin-top: 100px; background: #4acfee; border-radius: 10px; font-size: 85%';
    floatRight.innerHTML = `<h1>${value}</h1>`;

    const clearBoth = document.createElement('div');
    clearBoth.style.clear = 'both';

    chatbox.appendChild(floatRight);
    chatbox.appendChild(clearBoth);
    contentBox?.appendChild(chatbox);

    axios
      .post('/send', { input: value })
      .then(response => {
        const responseData = response.data;

        const dFlex = document.createElement('div');
        dFlex.className = 'd-flex mb-2';

        const avatarContainer = document.createElement('div');
        avatarContainer.className = 'mr-2';
        avatarContainer.style.cssText = 'width: 45px; margin-top: 100px; height: 45px';

        const avatarImage = document.createElement('img');
        avatarImage.src = 'https://icon-library.com/images/avatar-icon-images/avatar-icon-images-4.jpg';
        avatarImage.width = 45;
        avatarImage.height = 45;
        avatarImage.style.borderRadius = '50px';

        const textContainer = document.createElement('div');
        textContainer.className = 'text-white px-3 py-2';
        textContainer.style.cssText =
          'width: 500px; background: #13254b; border-radius:10px; margin-top: 100px; font-size: 85%';
        textContainer.innerHTML = `<h1>${responseData}</h1>`;

        dFlex.appendChild(avatarContainer);
        dFlex.appendChild(textContainer);

        contentBox?.appendChild(dFlex);

        setInputValue('');
      })
      .catch(error => {
        console.error(error);
      });
  };

  return (
    <div>
      <div className="container-fluid m-0 d-flex p-2">
        <div className="pl-2" style={{ width: '40px', height: '50px', fontSize: '180%' }}>
          <i className="fa fa-angle-double-left text-white mt-2"></i>
        </div>
        <div style={{ width: '50px', height: '50px' }}>
          <img
            src="https://icon-library.com/images/avatar-icon-images/avatar-icon-images-4.jpg"
            width="100%"
            height="100%"
            style={{ borderRadius: '50px' }}
          />
        </div>
        <div className="text-white font-weight-bold ml-2 mt-2">Chatbot</div>
        <div style={{ background: '#061128', height: '2px' }}></div>
        <div
          id="content-box"
          className="container-fluid p-2"
          style={{ height: 'calc(100vh - 130px)', overflowY: 'scroll' }}
        ></div>
      </div>
      <div className="container-fluid w-50 px-3 py-2 d-flex" style={{ background: '#131f45', height: '62px' }}>
        <div className="mr-2 pl-2" style={{ background: '#ffffff1c', width: 'calc(100% - 20px)', borderRadius: '5px' }}>
          <input
            type="text"
            id="input"
            className="text-white"
            name="input"
            style={{ background: 'none', width: '100%', height: '100%', border: '0', outline: 'none' }}
            value={inputValue}
            onChange={handleInputChange}
          />
        </div>
        <div
          id="button-submit"
          className="text-center"
          style={{ background: '#4acfee', height: '100%', width: '50px', borderRadius: '5px' }}
          onClick={handleButtonClick}
        >
          <i className="fa fa-paper-plane text-white" aria-hidden="true" style={{ lineHeight: '45px' }}></i>
        </div>
      </div>
    </div>
  );
};

export default Chatbot;
