import { db } from "./../data/db.js";

export const auth = (req, res, next) => {
  const authHeader = req.headers.authorization;

  if (!authHeader || !authHeader.startsWith("Bearer ")) {
    return res.status(401).json({ message: "Unauthorized: No token provided" });
  }

  const token = authHeader.split(" ")[1];
  const user = db.users.find((u) => u.token === token);

  if (!user) {
    return res.status(401).json({ message: "Unauthorized: Invalid token" });
  }

  // You can attach the user to req for later use if needed
  req.user = user;

  next();
};
