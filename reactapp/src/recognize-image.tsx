import { useState } from 'react';
import axios from 'axios';

const RecognizeImageForm = () => {
  const [imageTags, setImageTags] = useState<string[]>([]);

  const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    const formData = new FormData(event.currentTarget);
    const imageUrl = formData.get('image_url');

    axios
      .post('/recognize-image', { image_url: imageUrl })
      .then((response) => {
        // Handle the response from the server and get the first 20 tags
        const tags = response.data.result.tags
          .slice(0, 20)
          .map((tagData: { tag: { en: any } }) => tagData.tag.en);
        setImageTags(tags);
      })
      .catch((error) => {
        console.error(error);
      });
  };

  return (
    <div>
      <h1>Image Recognition</h1>
      <form onSubmit={handleSubmit}>
        {/* Add your form elements here */}
        <label htmlFor="image_url">Image URL:</label>
        <input type="text" name="image_url" id="image_url" required />
        <button type="submit">Recognize Image</button>
      </form>

      <div>
        <h2>Image Tags:</h2>
        <ul>
          {imageTags.map((tag, index) => (
            <li key={index}>{tag}</li>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default RecognizeImageForm;
