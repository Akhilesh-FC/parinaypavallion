const { User, Booking, Property } = require("../../models");

/* =========================
   REGISTERED USERS
========================= */
exports.listUsers = async (req, res) => {
  try {
    const users = await User.findAll({
      attributes: ["id", "name", "email", "mobile", "created_at"],
      order: [["id", "DESC"]]
    });

    res.render("admin/users/list", {
      title: "Registered Users",
      users
    });
  } catch (err) {
    res.send(err.message);
  }
};

/* =========================
   USER BOOKING HISTORY
========================= */
exports.userBookings = async (req, res) => {
  try {
    const user = await User.findByPk(req.params.id);

    if (!user) {
      return res.redirect("/admin/users");
    }

   const bookings = await Booking.findAll({
  where: { user_id: user.id },
  include: [
    {
      model: Property,
      required: false   // 👈 IMPORTANT (prevents crash)
    }
  ],
  order: [["id", "DESC"]]
});


    res.render("admin/users/bookings", {
      title: "User Booking History",
      user,
      bookings
    });
  } catch (err) {
    res.send(err.message);
  }
};
