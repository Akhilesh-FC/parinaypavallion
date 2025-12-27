const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const ContactMessage = sequelize.define("contact_messages", {
  name: DataTypes.STRING,
  mobile: DataTypes.STRING,
  email: DataTypes.STRING,
  message: DataTypes.TEXT
}, {
  timestamps: false
});

module.exports = ContactMessage;
