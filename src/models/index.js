const Property = require("./Property");
const PropertyImage = require("./PropertyImage");
const Facility = require("./Facility");
const PropertyFacility = require("./PropertyFacility");

/* =========================
   PROPERTY ↔ IMAGES
========================= */
Property.hasMany(PropertyImage, {
  foreignKey: "property_id",
  as: "images"
});

PropertyImage.belongsTo(Property, {
  foreignKey: "property_id"
});

/* =========================
   PROPERTY ↔ FACILITIES (MANY TO MANY)
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

module.exports = {
  Property,
  PropertyImage,
  Facility,
  PropertyFacility
};







const PropertyAvailability = require("./PropertyAvailability");

// existing exports ke saath
module.exports = {
  Property,
  PropertyImage,
  Facility,
  PropertyFacility,
  PropertyAvailability
};

