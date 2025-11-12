<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>StudyCoach | Achievements</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(180deg, #0a1a3a, #0d1e4a);
      color: white;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      background: rgba(255, 255, 255, 0.08);
      border-radius: 1rem;
      padding: 1.5rem;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      transition: transform 0.2s ease;
    }
    .card:hover {
      transform: scale(1.02);
    }
    .badge {
      background: linear-gradient(90deg, #1e90ff, #6a5acd);
      padding: 0.4rem 1rem;
      border-radius: 9999px;
      font-weight: 600;
    }
  </style>
</head>

<body class="min-h-screen flex flex-col items-center py-10">

  <!-- Back to Dashboard -->
  <div class="absolute top-6 left-6">
    <a href="dashboard.php" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-xl shadow-lg transition">
      ← Back to Dashboard
    </a>
  </div>

  <h1 class="text-4xl font-bold text-blue-400 mb-6 text-center">🏆 StudyCoach Achievements</h1>
  <p class="text-gray-300 text-center mb-10 max-w-2xl">
    Keep track of your study streak and milestones as you continue your StudyCoach journey!
  </p>

  <!-- Daily Study Streak -->
  <section class="card text-center w-11/12 md:w-1/2 mb-10">
    <h2 class="text-2xl font-semibold text-blue-300 mb-4">🔥 Daily Study Streak</h2>

    <div class="flex flex-col items-center space-y-4">
      <div id="streakDisplay" class="text-6xl font-bold text-blue-400">0</div>
      <p class="text-gray-400">Days in a row of active studying</p>

      <div class="flex gap-3">
        <button onclick="incrementStreak()" class="px-5 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg font-semibold transition">
          +1 Day
        </button>
        <button onclick="resetStreak()" class="px-5 py-2 bg-red-500 hover:bg-red-600 rounded-lg font-semibold transition">
          Reset
        </button>
      </div>
    </div>
  </section>

  <!-- Achievements -->
  <section class="w-11/12 md:w-2/3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-center">
    <div class="card">
      <span class="text-5xl">🌟</span>
      <h3 class="text-xl font-bold text-blue-400 mt-2">First Study Day</h3>
      <p class="text-gray-400 mt-1 text-sm">Start your first study session</p>
      <div id="badge1" class="badge mt-3 hidden">Unlocked!</div>
    </div>

    <div class="card">
      <span class="text-5xl">🔥</span>
      <h3 class="text-xl font-bold text-blue-400 mt-2">5-Day Streak</h3>
      <p class="text-gray-400 mt-1 text-sm">Study for 5 consecutive days</p>
      <div id="badge5" class="badge mt-3 hidden">Unlocked!</div>
    </div>

    <div class="card">
      <span class="text-5xl">💪</span>
      <h3 class="text-xl font-bold text-blue-400 mt-2">10-Day Streak</h3>
      <p class="text-gray-400 mt-1 text-sm">Stay consistent for 10 days</p>
      <div id="badge10" class="badge mt-3 hidden">Unlocked!</div>
    </div>

    <div class="card">
      <span class="text-5xl">📘</span>
      <h3 class="text-xl font-bold text-blue-400 mt-2">Focused Learner</h3>
      <p class="text-gray-400 mt-1 text-sm">Complete 10 study sessions</p>
    </div>

    <div class="card">
      <span class="text-5xl">🏅</span>
      <h3 class="text-xl font-bold text-blue-400 mt-2">Top Scholar</h3>
      <p class="text-gray-400 mt-1 text-sm">Unlock all major achievements</p>
    </div>
  </section>

  <script>
    let streak = localStorage.getItem('studyStreak') ? parseInt(localStorage.getItem('studyStreak')) : 0;
    const streakDisplay = document.getElementById('streakDisplay');

    function updateDisplay() {
      streakDisplay.textContent = streak;
      checkAchievements();
    }

    function incrementStreak() {
      streak++;
      localStorage.setItem('studyStreak', streak);
      updateDisplay();
    }

    function resetStreak() {
      if (confirm("Are you sure you want to reset your streak?")) {
        streak = 0;
        localStorage.setItem('studyStreak', streak);
        updateDisplay();
      }
    }

    function checkAchievements() {
      document.getElementById('badge1').classList.toggle('hidden', streak < 1);
      document.getElementById('badge5').classList.toggle('hidden', streak < 5);
      document.getElementById('badge10').classList.toggle('hidden', streak < 10);
    }

    updateDisplay();
  </script>
</body>
</html>
