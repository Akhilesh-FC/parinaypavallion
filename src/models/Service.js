const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Service = sequelize.define("services", {
  id: {
    type: DataTypes.BIGINT.UNSIGNED,
    autoIncrement: true,
    primaryKey: true
  },
  icon: {
    type: DataTypes.STRING,
    allowNull: false
  },
  title: {
    type: DataTypes.STRING,
    allowNull: false
  },
  description: {
    type: DataTypes.TEXT,
    allowNull: false
  },
  status: {
    type: DataTypes.TINYINT,
    defaultValue: 1
  }
}, {
  timestamps: true,
  createdAt: "created_at",
  updatedAt: "updated_at"
});

module.exports = Service;
