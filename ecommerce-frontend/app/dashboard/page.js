"use client";

import { useEffect, useState } from "react";
import axios from "axios";

const Dashboard = () => {
  const [user, setUser] = useState(null);

  useEffect(() => {
    const fetchUser = async () => {
      const token = localStorage.getItem("token");
      const response = await axios.get("http://localhost/api/me", {
        headers: { Authorization: `Bearer ${token}` },
      });
      setUser(response.data);
    };

    fetchUser();
  }, []);

  return (
    <div className="p-6 bg-gray-100">
      <h1 className="text-2xl font-bold mb-4">Dashboard</h1>
      {user && (
        <div className="bg-white p-4 rounded shadow">
          <p className="text-lg">Name: {user.name}</p>
          <p className="text-lg">Email: {user.email}</p>
        </div>
      )}
    </div>
  );
};

export default Dashboard;
