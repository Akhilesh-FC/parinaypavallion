const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Slider = sequelize.define("Slider", {
  id: {
    type: DataTypes.BIGINT.UNSIGNED,
    autoIncrement: true,
    primaryKey: true
  },
  title: {
    type: DataTypes.STRING,
    allowNull: true
  },
  image: {
    type: DataTypes.STRING,
    allowNull: false
  },
  link: {
    type: DataTypes.STRING,
    allowNull: true
  },
  status: {
    type: DataTypes.TINYINT,
    defaultValue: 1
  }
}, {
  tableName: "sliders",
  timestamps: true   // 👈 DEFAULT Sequelize columns
  // ❌ createdAt / updatedAt mapping REMOVE
});

module.exports = Slider;
