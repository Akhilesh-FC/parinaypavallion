const {
  Booking,
  Property,
  PropertyAvailability
} = require("../../models");

/* =========================
   CREATE BOOKING (INSTALLMENT 1)
========================= */
exports.createBooking = async (req, res) => {
  try {
    const user_id = req.user.id;

    const {
      property_id,
      booking_date,
      time_slot,
      guest_count,
      booking_amount
    } = req.body;

    if (
      !property_id ||
      !booking_date ||
      !time_slot ||
      !guest_count ||
      !booking_amount
    ) {
      return res.status(400).json({
        status: false,
        message: "All fields are required"
      });
    }

    // 1️⃣ Property
    const property = await Property.findByPk(property_id);
    if (!property) {
      return res.status(404).json({
        status: false,
        message: "Property not found"
      });
    }

    // 2️⃣ Guest validation
    if (
      guest_count < property.min_guests ||
      guest_count > property.max_guests
    ) {
      return res.status(400).json({
        status: false,
        message: `Guest limit ${property.min_guests}-${property.max_guests}`
      });
    }

    // 3️⃣ Availability check
    const availability = await PropertyAvailability.findOne({
      where: { property_id, date: booking_date, time_slot }
    });

    if (availability && availability.is_available === 0) {
      return res.json({
        status: false,
        message: "Slot already booked"
      });
    }

    // 4️⃣ Amount logic
    const total_amount = Number(property.base_price);

    if (booking_amount >= total_amount) {
      return res.status(400).json({
        status: false,
        message: "Booking amount must be less than total amount"
      });
    }

    // 5️⃣ Create booking
    const booking = await Booking.create({
      user_id,
      property_id,
      booking_date,
      time_slot,
      guest_count,
      total_amount,
      booking_amount,
      paid_amount: booking_amount,
      payment_status: "partial"
    });

    // 6️⃣ Lock slot
    if (availability) {
      await availability.update({ is_available: 0 });
    } else {
      await PropertyAvailability.create({
        property_id,
        date: booking_date,
        time_slot,
        is_available: 0
      });
    }

    return res.json({
      status: true,
      message: "Booking confirmed with advance payment",
      booking_id: booking.id,
      total_amount,
      paid_amount: booking.paid_amount,
      remaining_amount: total_amount - booking.paid_amount
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};



/* =========================
   PAY NEXT INSTALLMENT
========================= */
exports.payInstallment = async (req, res) => {
  try {
    const { booking_id, amount } = req.body;

    if (!booking_id || !amount) {
      return res.status(400).json({
        status: false,
        message: "booking_id and amount required"
      });
    }

    const booking = await Booking.findByPk(booking_id);

    if (!booking) {
      return res.status(404).json({
        status: false,
        message: "Booking not found"
      });
    }

    const newPaid = Number(booking.paid_amount) + Number(amount);

    if (newPaid > booking.total_amount) {
      return res.status(400).json({
        status: false,
        message: "Payment exceeds total amount"
      });
    }

    // Decide installment slot
    let updateData = { paid_amount: newPaid };

    if (booking.second_amount === 0) {
      updateData.second_amount = amount;
    } else {
      updateData.final_amount = amount;
      updateData.payment_status = "paid";
    }

    await booking.update(updateData);

    return res.json({
      status: true,
      message: "Payment received",
      paid_amount: newPaid,
      remaining_amount: booking.total_amount - newPaid
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};





/* =========================
   USER BOOKING HISTORY
========================= */
exports.myBookings = async (req, res) => {
  try {
    const user_id = req.user.id; // 👈 JWT se

    const bookings = await Booking.findAll({
      where: { user_id },
      attributes: [
        "id",
        "booking_date",
        "time_slot",
        "guest_count",
        "total_amount",
        "paid_amount",
        "booking_amount",
        "second_amount",
        "final_amount",
        "booking_status",
        "payment_status",
        "created_at"
      ],
      include: [
        {
          model: Property,
          attributes: ["name", "type"]
        }
      ],
      order: [["id", "DESC"]]
    });

    return res.json({
      status: true,
      data: bookings
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};

