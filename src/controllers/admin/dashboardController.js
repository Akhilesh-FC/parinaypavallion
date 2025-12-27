const { Op } = require("sequelize");
const {
  Booking,
  Property,
  User,
  Gallery,
  ContactMessage
} = require("../../models");

exports.dashboard = async (req, res) => {
  try {
    const [
      totalUsers,
      totalBookings,
      upcomingBookings,
      totalLawns,
      totalHalls,
      totalRooms,
      totalGalleryImages,
      totalEnquiries,
      totalRevenue
    ] = await Promise.all([
      User.count(),
      Booking.count(),
      Booking.count({
        where: { booking_date: { [Op.gte]: new Date() } }
      }),
      Property.count({ where: { type: "lawn" } }),
      Property.count({ where: { type: "hall" } }),
      Property.count({ where: { type: "room" } }),
      Gallery.count(),
      ContactMessage.count(),
      Booking.sum("paid_amount")
    ]);

    res.render("admin/dashboard", {
      title: "Admin Dashboard | Parinay Pavilion",
      totalUsers,
      totalBookings,
      upcomingBookings,
      totalLawns,
      totalHalls,
      totalRooms,
      totalGalleryImages,
      totalEnquiries,
      totalRevenue: totalRevenue || 0
    });

  } catch (error) {
    console.error(error);
    res.send(error.message);
  }
};
