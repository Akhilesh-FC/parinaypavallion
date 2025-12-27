const { Booking, Property, User } = require("../../models");

// ======================
// ALL BOOKINGS
// ======================

exports.allBookings = async (req, res) => {
  const bookings = await Booking.findAll({
    include: [
      { model: User, required: false },      // LEFT JOIN
      { model: Property, required: false }   // LEFT JOIN
    ],
    order: [["id", "DESC"]]
  });

  res.render("admin/bookings/all", {
    title: "All Bookings",
    bookings
  });
};


// ======================
// PENDING BOOKINGS
// ======================
exports.pendingBookings = async (req, res) => {
  const bookings = await Booking.findAll({
    where: { booking_status: "pending" },
    include: [Property, User],
    order: [["id", "DESC"]]
  });

  res.render("admin/bookings/pending", {
    title: "Pending Bookings",
    bookings
  });
};

// ======================
// APPROVE
// ======================
exports.approveBooking = async (req, res) => {
  await Booking.update(
    { booking_status: "approved" },
    { where: { id: req.params.id } }
  );
  res.redirect("/admin/bookings/pending");
};

// ======================
// REJECT
// ======================
exports.rejectBooking = async (req, res) => {
  await Booking.update(
    { booking_status: "rejected" },
    { where: { id: req.params.id } }
  );
  res.redirect("/admin/bookings/pending");
};

// ======================
// EXPORT PAGE
// ======================
exports.exportPage = async (req, res) => {
  res.render("admin/bookings/export", {
    title: "Export Bookings"
  });
};
