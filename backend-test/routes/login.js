import express from "express";
import { db } from "../data/db.js";

const router = express.Router();

router.post("/", (req, res) => {
  const { email, password } = req.body;
  if (!email || !password)
    return res
      .status(400)
      .json({ message: "Email and password are required." });

  const user = db.users.find(
    (u) => u.email === email && u.password === password
  );
  if (!user) return res.status(401).json({ message: "Invalid credentials." });

  res.json({
    token: user.token,
    user: {
      id: user.id,
      name: user.name,
      email: user.email,
      table: user.table,
    },
  });
});

export default router;
