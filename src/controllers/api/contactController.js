const {
  ContactDetail,
  ContactMessage,
  SocialLink
} = require("../../models");

/* =========================
   GET CONTACT INFO
========================= */
exports.getContactInfo = async (req, res) => {
  try {
    const contact = await ContactDetail.findOne();
    const social = await SocialLink.findOne({
      attributes: ["facebook", "instagram"]
    });

    return res.json({
      status: true,
      data: {
        address: contact?.address,
        phone: contact?.phone,
        email: contact?.email,
        social
      }
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};

/* =========================
   SEND MESSAGE
========================= */
exports.sendMessage = async (req, res) => {
  try {
    const { name, mobile, email, message } = req.body;

    if (!name || !mobile || !email || !message) {
      return res.status(400).json({
        status: false,
        message: "All fields are required"
      });
    }

    await ContactMessage.create({
      name,
      mobile,
      email,
      message
    });

    return res.json({
      status: true,
      message: "Message sent successfully"
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};
