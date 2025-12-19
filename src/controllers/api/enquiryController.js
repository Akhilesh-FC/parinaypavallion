const Enquiry = require("../../models/Enquiry");

exports.createEnquiry = async (req, res) => {
  try {
    const { name, email, mobile, message } = req.body;

    if (!name || !mobile) {
      return res.json({
        status: false,
        message: "Name and mobile required"
      });
    }

    await Enquiry.create({ name, email, mobile, message });

    res.json({
      status: true,
      message: "Enquiry submitted successfully"
    });

  } catch (error) {
    res.status(500).json({
      status: false,
      message: error.message
    });
  }
};




exports.send = async (req, res) => {
  await Enquiry.create(req.body);
  res.json({ status: true, message: "Message sent" });
};
