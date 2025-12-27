const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const ContactDetail = sequelize.define("contact_details", {
  address: DataTypes.TEXT,
  phone: DataTypes.STRING,
  email: DataTypes.STRING
}, {
  timestamps: true,
  createdAt: "created_at",
  updatedAt: "updated_at"
});

module.exports = ContactDetail;
