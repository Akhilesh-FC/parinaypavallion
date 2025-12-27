/* =========================
   IMPORT MODELS
========================= */

const Property = require("./Property");
const PropertyImage = require("./PropertyImage");
const Facility = require("./Facility");
const PropertyFacility = require("./PropertyFacility");
const PropertyAvailability = require("./PropertyAvailability");

const Booking = require("./Booking");

const ContactDetail = require("./ContactDetail");
const ContactMessage = require("./ContactMessage");
const SocialLink = require("./SocialLink");
const Gallery = require("./Gallery");

const Admin = require("./Admin");
const Service = require("./Service");
const User = require("./User");
const Slider = require("./Slider");

/* =========================
   PROPERTY ↔ IMAGES (1 : MANY)
========================= */
Property.hasMany(PropertyImage, {
  foreignKey: "property_id",
  as: "images"
});
PropertyImage.belongsTo(Property, {
  foreignKey: "property_id"
});

/* =========================
   PROPERTY ↔ FACILITIES (MANY : MANY)
========================= */
Property.belongsToMany(Facility, {
  through: PropertyFacility,
  foreignKey: "property_id",
  otherKey: "facility_id",
  as: "facilities"
});
Facility.belongsToMany(Property, {
  through: PropertyFacility,
  foreignKey: "facility_id",
  otherKey: "property_id"
});

/* =========================
   PROPERTY ↔ BOOKINGS
========================= */
Property.hasMany(Booking, {
  foreignKey: "property_id"
});
Booking.belongsTo(Property, {
  foreignKey: "property_id"
});

/* =========================
   USER ↔ BOOKINGS
========================= */
User.hasMany(Booking, {
  foreignKey: "user_id"
});
Booking.belongsTo(User, {
  foreignKey: "user_id"
});





Booking.belongsTo(Property, {
  foreignKey: "property_id"
});

Property.hasMany(Booking, {
  foreignKey: "property_id"
});

Booking.belongsTo(User, {
  foreignKey: "user_id"
});

User.hasMany(Booking, {
  foreignKey: "user_id"
});

/* =========================
   EXPORT MODELS
========================= */
module.exports = {
  Property,
  PropertyImage,
  Facility,
  PropertyFacility,
  PropertyAvailability,
  Booking,
  ContactDetail,
  ContactMessage,
  SocialLink,
  Gallery,
  Admin,
  Service,
  User,Slider
};
