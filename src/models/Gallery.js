const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Gallery = sequelize.define(
  "Gallery",
  {
    id: {
      type: DataTypes.BIGINT.UNSIGNED,
      autoIncrement: true,
      primaryKey: true
    },
    image: {
      type: DataTypes.STRING,
      allowNull: false
    },
    type: {
      type: DataTypes.STRING,
      allowNull: true
    }
  },
  {
    tableName: "gallery",        // ✅ EXACT TABLE NAME
    timestamps: true,
    createdAt: "created_at",
    updatedAt: false
  }
);

module.exports = Gallery;
