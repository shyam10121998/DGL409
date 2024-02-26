const express = require('express');
const fetch = require('node-fetch');
const app = express();

const PORT = process.env.PORT || 3000;

app.get('/swimming', async (req, res) => {
  const { latitude, longitude } = req.query;
  const radius = 5000;
  const apiKey = 'AIzaSyDtOEtcnrjVWnTea8XNCQ52KUOAb0_US8o'; 
  const url = `https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=${latitude},${longitude}&radius=${radius}&keyword=swimming&key=${apiKey}`;

  try {
    const response = await fetch(url);
    const data = await response.json();
    res.json(data.results);
  } catch (error) {
    console.error('Error fetching nearby swimming places:', error);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
