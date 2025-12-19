const app = require("./src/app");
const sequelize = require("./src/config/database");
require("dotenv").config();


const PORT = process.env.PORT || 5002;

sequelize.authenticate()
  .then(() => {
    console.log("Database connected");
    app.listen(PORT, () => {
      console.log(`Server running on port ${PORT}`);
    });
  })
  .catch(err => {
    console.log("DB Error:", err.message);
  });
