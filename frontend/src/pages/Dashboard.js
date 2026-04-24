import React from 'react';
import { motion } from 'framer-motion';
import { FaUser, FaCalendarAlt, FaShoppingBag, FaHeart, FaClock, FaMapMarkerAlt } from 'react-icons/fa';
import { useAuth } from '../context/AuthContext';
import { useReservations } from '../hooks/useReservations';

const Dashboard = () => {
  const { user } = useAuth();
  const { reservations, loading, cancelReservation } = useReservations();

  const stats = [
    { icon: FaCalendarAlt, label: 'Reservations', value: reservations.length, color: 'bg-blue-100 text-blue-600' },
    { icon: FaShoppingBag, label: 'Orders', value: 12, color: 'bg-green-100 text-green-600' },
    { icon: FaHeart, label: 'Favorites', value: 8, color: 'bg-red-100 text-red-600' },
    {
      icon: FaClock, label: 'Member Since', value: user?.created_at
        ? new Date(user.created_at).toLocaleDateString('en-GB', {
          day: 'numeric',
          month: 'short',
          year: 'numeric'
        })
        : '2026', color: 'bg-purple-100 text-purple-600'
    },
  ];



  return (
    <div className="min-h-screen bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          className="mb-8"
        >
          <h1 className="text-4xl font-serif font-bold text-gray-900">My Dashboard</h1>
          <p className="text-gray-500 mt-2">Welcome back, {user?.name}!</p>
        </motion.div>

        {/* Stats Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          {stats.map((stat, index) => (
            <motion.div
              key={stat.label}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.1 }}
              className="bg-white rounded-xl shadow-md p-6"
            >
              <div className={`w-12 h-12 ${stat.color} rounded-lg flex items-center justify-center mb-4`}>
                <stat.icon className="text-xl" />
              </div>
              <p className="text-2xl font-bold text-gray-900">{stat.value}</p>
              <p className="text-gray-500 text-sm">{stat.label}</p>
            </motion.div>
          ))}
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Profile Card */}
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            className="bg-white rounded-2xl shadow-lg p-8"
          >
            <div className="flex items-center space-x-4 mb-6">
              <div className="w-16 h-16 bg-gradient-to-br from-primary-600 to-gold-500 rounded-full flex items-center justify-center">
                <FaUser className="text-white text-2xl" />
              </div>
              <div>
                <h3 className="text-xl font-serif font-semibold">{user?.name}</h3>
                <p className="text-gray-500 text-sm">{user?.email}</p>
              </div>
            </div>

            <div className="space-y-4">
              <div className="flex items-center space-x-3 text-gray-600">
                <FaMapMarkerAlt className="text-primary-500" />
                <span>Syria</span>
              </div>
              <div className="flex items-center space-x-3 text-gray-600">
                <FaCalendarAlt className="text-primary-500" />
                <span>
                  Member since {user?.created_at ?
                    new Date(user.created_at).toLocaleDateString('en-GB', {
                      day: 'numeric',
                      month: 'long',
                      year: 'numeric',
                      hour: 'numeric',
                      minute: 'numeric',
                    })
                    : 'Loading date...'}
                </span>
              </div>
            </div>

            <button className="w-full mt-6 py-3 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
              Edit Profile
            </button>
          </motion.div>

          {/* Reservations */}
          <motion.div
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            className="lg:col-span-2 bg-white rounded-2xl shadow-lg p-8"
          >
            <h3 className="text-xl font-serif font-semibold mb-6">My Reservations</h3>

            {loading ? (
              <div className="flex justify-center py-8">
                <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
              </div>
            ) : reservations.length === 0 ? (
              <div className="text-center py-8 text-gray-500">
                <FaCalendarAlt className="text-4xl mx-auto mb-2 text-gray-300" />
                <p>No reservations yet</p>
              </div>
            ) : (
              <div className="space-y-4">
                {reservations.map((reservation) => (
                  <div
                    key={reservation.id}
                    className="border border-gray-100 rounded-xl p-4 flex items-center justify-between hover:shadow-md transition-shadow"
                  >
                    <div className="flex items-center space-x-4">
                      <div className="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                        <FaCalendarAlt className="text-primary-600" />
                      </div>
                      <div>
                        <p className="font-semibold">{reservation.date}</p>
                        <p className="text-sm text-gray-500">{reservation.time} • {reservation.guests} guests</p>
                      </div>
                    </div>
                    <div className="flex items-center space-x-3">
                      <span className={`px-3 py-1 rounded-full text-xs font-medium
                        ${reservation.status === 'confirmed' ? 'bg-green-100 text-green-600' :
                          reservation.status === 'pending' ? 'bg-yellow-100 text-yellow-600' :
                            'bg-red-100 text-red-600'}`}>
                        {reservation.status}
                      </span>
                      <button
                        onClick={() => cancelReservation(reservation.id)}
                        className="text-red-500 hover:text-red-700 text-sm"
                      >
                        Cancel
                      </button>
                    </div>
                  </div>
                ))}
              </div>
            )}
          </motion.div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
