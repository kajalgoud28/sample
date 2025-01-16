const express = require('express');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;

// Serve static files (CSS and images) from the 'css' and 'images' directories
app.use('/css', express.static(path.join(__dirname, 'css')));
app.use('/images', express.static(path.join(__dirname, 'images')));

// Serve the index.php file
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.php'));
});

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
