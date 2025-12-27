const User = require("../../models/User");
const bcrypt = require("bcryptjs");
const jwt = require("jsonwebtoken");
const validator = require("validator");

const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/;

/* =========================
   REGISTER
========================= */
exports.register = async (req, res) => {
  try {
    const { name, email, mobile, password } = req.body;

    // Basic validation
    if (!name || !password || (!email && !mobile)) {
      return res.status(400).json({
        status: false,
        message: "Name, password and email or mobile required"
      });
    }

    // Email validation
    if (email && !validator.isEmail(email)) {
      return res.status(400).json({
        status: false,
        message: "Invalid email format"
      });
    }

    // Password validation
    if (!passwordRegex.test(password)) {
      return res.status(400).json({
        status: false,
        message:
          "Password must be 6+ chars with upper, lower & number"
      });
    }

    // Check existing user
    const exists = await User.findOne({
      where: email ? { email } : { mobile }
    });

    if (exists) {
      return res.status(409).json({
        status: false,
        message: "User already exists"
      });
    }

    // Hash password
    const hashedPassword = await bcrypt.hash(password, 10);

    // Create user
    const user = await User.create({
      name,
      email,
      mobile,
      password: hashedPassword
    });

    // ✅ GENERATE TOKEN (SAME AS LOGIN)
    const token = jwt.sign(
      { id: user.id },
      process.env.JWT_SECRET,
      { expiresIn: "7d" }
    );

    // ✅ RETURN USER + TOKEN
    return res.json({
      status: true,
      message: "Registration successful",
      token,
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        mobile: user.mobile,
        created_at: user.created_at || null
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
   LOGIN
========================= */
exports.login = async (req, res) => {
  try {
    const { email, mobile, password } = req.body;

    if ((!email && !mobile) || !password) {
      return res.status(400).json({
        status: false,
        message: "Email/mobile and password required"
      });
    }

    const user = await User.findOne({
      where: email ? { email } : { mobile }
    });

    if (!user) {
      return res.status(401).json({
        status: false,
        message: "Invalid credentials"
      });
    }

    const isMatch = await bcrypt.compare(password, user.password);

    if (!isMatch) {
      return res.status(401).json({
        status: false,
        message: "Invalid credentials"
      });
    }

    const token = jwt.sign(
      { id: user.id },
      process.env.JWT_SECRET,
      { expiresIn: "7d" }
    );

    return res.json({
      status: true,
      token,
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        mobile: user.mobile
      }
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};
