const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Booking = sequelize.define(
  "Booking",
  {
    id: {
      type: DataTypes.BIGINT.UNSIGNED,
      autoIncrement: true,
      primaryKey: true
    },
    user_id: {
      type: DataTypes.BIGINT.UNSIGNED,
      allowNull: false
    },
    property_id: {
      type: DataTypes.BIGINT.UNSIGNED,
      allowNull: false
    },
    booking_date: {
      type: DataTypes.DATEONLY,
      allowNull: false
    },
    time_slot: {
      type: DataTypes.STRING,
      allowNull: false
    },
    guest_count: {
      type: DataTypes.INTEGER,
      allowNull: false
    },
    total_amount: {
      type: DataTypes.DECIMAL(10,2),
      allowNull: false
    },
    booking_amount: {
      type: DataTypes.DECIMAL(10,2),
      allowNull: false
    },
    second_amount: {
      type: DataTypes.DECIMAL(10,2),
      defaultValue: 0
    },
    final_amount: {
      type: DataTypes.DECIMAL(10,2),
      defaultValue: 0
    },
    paid_amount: {
      type: DataTypes.DECIMAL(10,2),
      defaultValue: 0
    },
    booking_status: {
      type: DataTypes.STRING,
      defaultValue: "confirmed"
    },
    payment_status: {
      type: DataTypes.STRING,
      defaultValue: "partial" // partial | paid
    }
  },
  {
    tableName: "bookings",
    timestamps: true,
    createdAt: "created_at",
    updatedAt: false
  }
);

module.exports = Booking;
