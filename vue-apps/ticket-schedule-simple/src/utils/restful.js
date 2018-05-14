import axios from 'axios'

function query(url) {
  axios.get(
    url,
    {
      headers: {
        accept: 'application/json'
      }
    }
  ).then(
    (response) => {
      return response.data;
    }
  ).catch((error) => {
      return null
    }
  );


}