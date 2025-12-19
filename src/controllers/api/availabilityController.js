const { Property, PropertyAvailability } = require("../../models");



/* =========================
   DROPDOWN: VENUE / ROOM
========================= */
exports.getVenuesForDropdown = async (req, res) => {
  try {
    const data = await Property.findAll({
      where: { status: 1 },
      attributes: ["id", "type", "name"],
      order: [["type", "ASC"], ["name", "ASC"]]
    });

    return res.json({
      status: true,
      data
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};


/* =========================
   EVENT TYPES
========================= */
exports.getEventTypes = (req, res) => {
  return res.json({
    status: true,
    data: [
      { key: "wedding", label: "Wedding" },
      { key: "reception", label: "Reception" },
      { key: "engagement", label: "Engagement" },
      { key: "party", label: "Party" }
    ]
  });
};



/* =========================
   CHECK AVAILABILITY
========================= */
exports.checkAvailability = async (req, res) => {
  try {
    const { property_id, date, time_slot } = req.query;

    if (!property_id || !date || !time_slot) {
      return res.status(400).json({
        status: false,
        message: "property_id, date and time_slot required"
      });
    }

    const record = await PropertyAvailability.findOne({
      where: {
        property_id,
        date,
        time_slot
      }
    });

    if (!record || record.is_available === 1) {
      return res.json({
        status: true,
        available: true,
        message: "Venue is available"
      });
    }

    return res.json({
      status: true,
      available: false,
      message: "Venue is not available"
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};
