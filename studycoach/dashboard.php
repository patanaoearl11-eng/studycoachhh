<?php
session_start();

// Dummy user session for testing
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = 'testuser';
}

// Temporary logout handling
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>StudyCoach - Dashboard (Portrait)</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex text-white" style="background: linear-gradient(to bottom, #0f172a, #1e293b);">

<!-- Sidebar -->
<aside class="w-64 bg-gray-900 flex flex-col p-6">
  <h1 class="text-2xl font-bold mb-10 text-blue-400">📘 StudyCoach</h1>
  <nav class="flex flex-col space-y-4">
    <a href="mainpage.html" class="text-left hover:text-blue-400 transition transform hover:scale-110">🏠 Home</a>

  
    <!-- Create Reviewer Dropdown -->
    <div>
      <button onclick="toggleSubjects()" class="w-full text-left hover:text-blue-400 transition flex items-center justify-between transform hover:scale-110">
        ➕ Create Reviewer 
        <span id="arrow" class="transform transition-transform">▼</span>
      </button>

      <!-- Subject list (hidden by default) -->
      <div id="subjectList" class="hidden mt-2 ml-4 flex flex-col space-y-2">
        <a href="create_python.php" class="hover:text-blue-300 transition transform hover:scale-110">🐍 Python Fundamentals</a>
        <a href="create_htmlcss.php" class="hover:text-blue-300 transition transform hover:scale-110">🌐 HTML & CSS Fundamentals</a>
        <a href="create_php.php" class="hover:text-blue-300 transition transform hover:scale-110">💻 PHP Fundamentals</a>
        <a href="create_java.php" class="hover:text-blue-300 transition transform hover:scale-110">☕ Java Fundamentals</a>
        <a href="create_networking.php" class="hover:text-blue-300 transition transform hover:scale-110">🖧 Networking Fundamentals</a>
      </div>
    </div>

    <!-- Smart Quiz Generator -->
    <button onclick="showSection('quiz')" class="text-left hover:text-blue-400 transition transform hover:scale-110">🧠 Smart Quiz Generator</button>

    <!-- My Reviewers -->
    <button onclick="showSection('myReviewers')" class="text-left hover:text-blue-400 transition transform hover:scale-110">📚 My Reviewers</button>

    <button onclick="toggleTimer()" class="text-left hover:text-blue-400 transition transform hover:scale-110">
  ⏱️ Set Timer
</button>


    <button onclick="showSection('studyTracker')" class="text-left hover:text-blue-400 transition transform hover:scale-110">📊 Study Tracker</button>


    <button onclick="showSection('achievements')" class="text-left hover:text-blue-400 transition transform hover:scale-110">
  🏆 Achievements
</button>



    <!-- Exam Schedules -->
    <button onclick="showSection('scheduleSessions')" class="text-left hover:text-blue-400 transition transform hover:scale-110">📅 Schedule Sessions</button>

    <a href="dashboard.php" 
       class="text-1xl text-blue-400 hover:text-blue-700 font-bold transition transform hover:scale-110">
       🔙 Return to Dashboard
    </a>

   <a href="#"
   onclick="confirmLogout(event)"
   class="text-left hover:text-red-400 transition transform hover:scale-110">
   🚪 Logout
</a>

<script>
function confirmLogout(event) {
  event.preventDefault(); // Prevents the link from immediately redirecting
  const confirmed = confirm("Are you sure you want to log out?");
  if (confirmed) {
     window.location.href = "dashboard.php?logout=true";
  }
}
</script>
  </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 p-10 overflow-y-auto">  

  

    </div>
  </section>

  <!-- SMART QUIZ GENERATOR SECTION -->
  <section id="quiz" class="hidden">
    <h1 class="text-4xl font-bold mb-8 text-blue-400">🧠 Smart Quiz Generator</h1>
    <p class="text-gray-300 text-lg mb-10">Choose a type of quiz to start generating practice questions automatically.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

      <!-- Multiple Choice (Clickable) -->
      <div onclick="showSection('multipleChoiceSubjects')" 
           class="cursor-pointer bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
        <h2 class="text-xl font-semibold mb-2 text-blue-400">❓ Multiple Choice</h2>
        <p class="text-gray-300">Answer questions with multiple options — great for testing quick recall and topic coverage.</p>
      </div>

      <!-- Identification (Clickable) -->
      <div onclick="showSection('identificationSubjects')" 
           class="cursor-pointer bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
        <h2 class="text-xl font-semibold mb-2 text-blue-400">✏️ Identification</h2>
        <p class="text-gray-300">Provide short answers to test your ability to identify key concepts and terms.</p>
      </div>

    
      <!-- True or False card -->
<div onclick="showSection('trueFalseSubjects')" 
     class="cursor-pointer bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
  <h2 class="text-xl font-semibold mb-2 text-blue-400">✅ True or False</h2>
  <p class="text-gray-300">Decide whether each statement is true or false — a fast-paced knowledge check.</p>
</div>


      <!-- Essay card -->
<div onclick="showSection('essaySubjects')" 
     class="cursor-pointer bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
  <h2 class="text-xl font-semibold mb-2 text-blue-400">🧾 Essay</h2>
  <p class="text-gray-300">Write short or long-form answers to explain ideas in your own words.</p>
</div>
      <!-- Mixed Quiz card -->
      <div onclick="showSection('mixedSubjects')" 
     class="cursor-pointer bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
  <h2 class="text-xl font-semibold mb-2 text-blue-400">🎯 Mixed Quiz</h2>
  <p class="text-gray-300">Combine multiple question types for a complete review experience.</p>
</div>


      <!-- Code Snippet card -->
<div onclick="showSection('codeSnippetSubjects')" 
     class="cursor-pointer bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
  <h2 class="text-xl font-semibold mb-2 text-blue-400">💡 Code Snippet</h2>
  <p class="text-gray-300">Complete the code by filling out all the blanks.</p>
</div>

      <!-- Matching Type card -->
<div onclick="showSection('matchingSubjects')" 
     class="cursor-pointer bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
  <h2 class="text-xl font-semibold mb-2 text-blue-400">🔗 Matching Type</h2>
  <p class="text-gray-300">Respond to matching questions by pairing each of a set of stems.</p>
</div>


    </div>
  </section>

  <!-- MULTIPLE CHOICE SUBJECTS SECTION -->
  <section id="multipleChoiceSubjects" class="hidden p-10">
    <h1 class="text-4xl font-bold mb-8 text-blue-400">❓ Choose a Subject (Multiple Choice)</h1>
    <p class="text-gray-300 mb-10 text-lg">Select a subject below to start your multiple-choice quiz.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <a href="mcq_python.php" class="subject-link">🐍 Python Fundamentals</a>
      <a href="mcq_htmlcss.php" class="subject-link">🌐 HTML & CSS Fundamentals</a>
      <a href="mcq_php.php" class="subject-link">💻 PHP Fundamentals</a>
      <a href="mcq_java.php" class="subject-link">☕ Java Fundamentals</a>
      <a href="mcq_networking.php" class="subject-link">🖧 Networking Fundamentals</a>
    </div>

    <button onclick="showSection('quiz')" class="back-button">🔙 Back to Quiz Options</button>
  </section>

  <!-- IDENTIFICATION SUBJECTS SECTION -->
  <section id="identificationSubjects" class="hidden p-10">
    <h1 class="text-4xl font-bold mb-8 text-blue-400">✏️ Choose a Subject (Identification)</h1>
    <p class="text-gray-300 mb-10 text-lg">Select a subject below to start your identification quiz.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <a href="identification_python.php" class="subject-link">🐍 Python Fundamentals</a>
      <a href="identification_htmlcss.php" class="subject-link">🌐 HTML & CSS Fundamentals</a>
      <a href="identification_php.php" class="subject-link">💻 PHP Fundamentals</a>
      <a href="identification_java.php" class="subject-link">☕ Java Fundamentals</a>
      <a href="identification_networking.php" class="subject-link">🖧 Networking Fundamentals</a>
    </div>

    <button onclick="showSection('quiz')" class="back-button">🔙 Back to Quiz Options</button>
  </section>

 <!-- TRUE OR FALSE SUBJECTS SECTION -->
<section id="trueFalseSubjects" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">✅ Choose a Subject (True or False)</h1>
  <p class="text-gray-300 mb-10 text-lg">Select a subject below to start your True or False quiz.</p>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="tf_python.php" class="subject-link">🐍 Python Fundamentals</a>
    <a href="tf_htmlcss.php" class="subject-link">🌐 HTML & CSS Fundamentals</a>
    <a href="tf_php.php" class="subject-link">💻 PHP Fundamentals</a>
    <a href="tf_java.php" class="subject-link">☕ Java Fundamentals</a>
    <a href="tf_networking.php" class="subject-link">🖧 Networking Fundamentals</a>
  </div>

  <button onclick="showSection('quiz')" class="back-button">🔙 Back to Quiz Options</button>
</section>

<!-- ESSAY SUBJECTS SECTION -->
<section id="essaySubjects" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">🧾 Choose a Subject (Essay)</h1>
  <p class="text-gray-300 mb-10 text-lg">Select a subject below to start your Essay quiz.</p>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="essay_python.php" class="subject-link">🐍 Python Fundamentals</a>
    <a href="essay_htmlcss.php" class="subject-link">🌐 HTML & CSS Fundamentals</a>
    <a href="essay_php.php" class="subject-link">💻 PHP Fundamentals</a>
    <a href="essay_java.php" class="subject-link">☕ Java Fundamentals</a>
    <a href="essay_networking.php" class="subject-link">🖧 Networking Fundamentals</a>
  </div>

  <button onclick="showSection('quiz')" class="back-button">🔙 Back to Quiz Options</button>
</section>

<!-- MIXED QUIZ SUBJECTS SECTION -->
<section id="mixedSubjects" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">🎯 Choose a Subject (Mixed Quiz)</h1>
  <p class="text-gray-300 mb-10 text-lg">Select a subject below to start your Mixed Quiz.</p>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="mixed_python.php" class="subject-link">🐍 Python Fundamentals</a>
    <a href="mixed_htmlcss.php" class="subject-link">🌐 HTML & CSS Fundamentals</a>
    <a href="mixed_php.php" class="subject-link">💻 PHP Fundamentals</a>
    <a href="mixed_java.php" class="subject-link">☕ Java Fundamentals</a>
    <a href="mixed_networking.php" class="subject-link">🖧 Networking Fundamentals</a>
  </div>

  <button onclick="showSection('quiz')" class="back-button">🔙 Back to Quiz Options</button>
</section>

<!-- CODE SNIPPET SUBJECTS SECTION -->
<section id="codeSnippetSubjects" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">💡 Choose a Subject (Code Snippet)</h1>
  <p class="text-gray-300 mb-10 text-lg">Select a subject below to start your Code Snippet quiz.</p>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="codesnippet_python.php" class="subject-link">🐍 Python Fundamentals</a>
    <a href="codesnippet_htmlcss.php" class="subject-link">🌐 HTML & CSS Fundamentals</a><br> 
    <a href="codesnippet_php.php" class="subject-link">💻 PHP Fundamentals</a>
    <a href="codesnippet_java.php" class="subject-link">☕ Java Fundamentals</a>
    
  </div>

  <button onclick="showSection('quiz')" class="back-button">🔙 Back to Quiz Options</button>
</section>

<!-- MATCHING TYPE SUBJECTS SECTION -->
<section id="matchingSubjects" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">🔗 Choose a Subject (Matching Type)</h1>
  <p class="text-gray-300 mb-10 text-lg">Select a subject below to start your Matching Type quiz.</p>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="matching_python.php" class="subject-link">🐍 Python Fundamentals</a>
    <a href="matching_htmlcss.php" class="subject-link">🌐 HTML & CSS Fundamentals</a>
    <a href="matching_php.php" class="subject-link">💻 PHP Fundamentals</a>
    <a href="matching_java.php" class="subject-link">☕ Java Fundamentals</a>
    <a href="matching_networking.php" class="subject-link">🖧 Networking Fundamentals</a>
  </div>

  <button onclick="showSection('quiz')" class="back-button">🔙 Back to Quiz Options</button>
</section>

<!-- HOME DASHBOARD SECTION -->
<section id="home" class="p-10">
  <h1 class="text-4xl md:text-5xl font-bold text-center mb-10 text-blue-400">
    WELCOME TO STUDYCOACH: <span class="text-white">DASHBOARD</span>
  </h1>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
    
    <!-- Upload & Organize Card -->
    <div onclick="showSection('uploadOrganize')" 
         class="group bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300 cursor-pointer">
      <div class="flex items-center mb-4">
        <span class="text-yellow-400 text-4xl mr-3">📁</span>
        <h2 class="text-2xl font-bold text-blue-300 group-hover:text-blue-400">Upload & Organize</h2>
      </div>
      <p class="text-gray-300">
        Easily upload study materials, notes, and documents. Automatically organize them by subjects or topics for faster access.
      </p>
    </div>

    <!-- My Reviewers Card -->
    <div onclick="showSection('myReviewers')" 
         class="group bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300 cursor-pointer">
      <div class="flex items-center mb-4">
        <span class="text-purple-400 text-4xl mr-3">📚</span>
        <h2 class="text-2xl font-bold text-blue-300 group-hover:text-blue-400">My Reviewers</h2>
      </div>
      <p class="text-gray-300">
        Access all your saved reviewers, practice tests, and summaries in one place for quick study sessions.
      </p>
    </div>

    <!-- Study Tracker Card -->
    <div onclick="showSection('studyTracker')" 
         class="group bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300 cursor-pointer">
      <div class="flex items-center mb-4">
        <span class="text-green-400 text-4xl mr-3">📊</span>
        <h2 class="text-2xl font-bold text-blue-300 group-hover:text-blue-400">Study Tracker</h2>
      </div>
      <p class="text-gray-300">
        Track your progress with visual indicators to help you see what subjects or topics you need to review more.
      </p>
    </div>




    <!-- Study Coach Recommendations Card -->
    <div onclick="showSection('recommendations')" 
         class="group bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300 cursor-pointer">
      <div class="flex items-center mb-4">
        <span class="text-pink-400 text-4xl mr-3">🤖</span>
        <h2 class="text-2xl font-bold text-blue-300 group-hover:text-blue-400">Study Coach Recommendations</h2>
      </div>
      <p class="text-gray-300">
        Get personalized study tips and subject focus recommendations based on your recent activity and progress.
      </p>
    </div>

  </div>
</section>


<!-- 🌟 Floating Study Timer -->
<div id="floatingTimer" 
     class="hidden fixed top-1/2 right-10 transform -translate-y-1/2 bg-gradient-to-br from-gray-800 to-gray-700 p-6 rounded-3xl shadow-lg w-96 text-center border border-gray-600 z-50 transition-all duration-300">
  <h2 class="text-2xl font-semibold text-blue-300 mb-4">🕒 Study Timer</h2>
  <div id="timerDisplay" class="text-5xl font-bold text-blue-400 mb-6">00:00:00</div>

  <div class="flex justify-center gap-3 mb-4">
    <input type="number" id="hoursInput" placeholder="HH" min="0"
           class="w-20 bg-gray-900 border border-gray-700 text-gray-200 text-center p-3 rounded-lg focus:ring focus:ring-blue-500">
    <input type="number" id="minutesInput" placeholder="MM" min="0" max="59"
           class="w-20 bg-gray-900 border border-gray-700 text-gray-200 text-center p-3 rounded-lg focus:ring focus:ring-blue-500">
    <input type="number" id="secondsInput" placeholder="SS" min="0" max="59"
           class="w-20 bg-gray-900 border border-gray-700 text-gray-200 text-center p-3 rounded-lg focus:ring focus:ring-blue-500">
  </div>

  <div class="flex gap-2">
    <button onclick="startTimer()" 
            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition">▶️ Start</button>
    <button onclick="resetTimer()" 
            class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-lg transition">⏹️ Reset</button>
  </div>

  <div class="flex justify-between mt-4">
    <button onclick="toggleTimer()" 
            class="text-gray-400 hover:text-blue-400 transition text-sm">✖️ Close</button>
    <button onclick="minimizeTimer()" 
            class="text-gray-400 hover:text-blue-400 transition text-sm">➖ Minimize</button>
  </div>
</div>

<!-- 🌀 Minimized Timer Bubble -->
<div id="minimizedTimer" 
     class="hidden fixed bottom-10 right-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full w-20 h-20 flex items-center justify-center font-bold text-lg cursor-pointer shadow-lg transition-all duration-300 z-50"
     onclick="restoreTimer()">
  <span id="miniDisplay">00:00:00</span>
</div>



<!-- SCHEDULE SESSIONS SECTION -->
<section id="scheduleSessions" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">📅 Schedule Study Sessions</h1>
  <p class="text-gray-300 text-lg mb-10">
    Plan your study sessions in advance. Add subjects, dates, and time slots to keep your learning consistent and organized.
  </p>

  <!-- Schedule Form -->
  <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-10 rounded-3xl shadow-xl mb-10">
    <form id="sessionForm" class="space-y-6">
      <div>
        <label class="block text-gray-300 font-semibold mb-2">📘 Subject</label>
        <select id="subject" class="w-full bg-gray-900 border border-gray-700 text-gray-200 p-3 rounded-lg focus:ring focus:ring-blue-500">
          <option value="">-- Select Subject --</option>
          <option>🐍 Python Fundamentals</option>
          <option>🌐 HTML & CSS Fundamentals</option>
          <option>💻 PHP Fundamentals</option>
          <option>☕ Java Fundamentals</option>
          <option>🖧 Networking Fundamentals</option>
        </select>
      </div>

      <div>
        <label class="block text-gray-300 font-semibold mb-2">📅 Date</label>
        <input type="date" id="date" class="w-full bg-gray-900 border border-gray-700 text-gray-200 p-3 rounded-lg focus:ring focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-300 font-semibold mb-2">⏰ Time</label>
        <input type="time" id="time" class="w-full bg-gray-900 border border-gray-700 text-gray-200 p-3 rounded-lg focus:ring focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-300 font-semibold mb-2">📝 Notes</label>
        <textarea id="notes" rows="3" placeholder="Add session goals or reminders..." class="w-full bg-gray-900 border border-gray-700 text-gray-200 p-3 rounded-lg focus:ring focus:ring-blue-500"></textarea>
      </div>

      <button type="button" onclick="addSession()" class="px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold shadow-lg transition">
        ➕ Add Session
      </button>
    </form>
  </div>

  <!-- Scheduled Sessions List -->
  <div>
    <h2 class="text-2xl font-semibold text-blue-300 mb-4">📖 Upcoming Sessions</h2>
    <ul id="sessionList" class="space-y-4 text-gray-200">
      <li class="text-gray-400 italic">No scheduled sessions yet.</li>
    </ul>
  </div>

    <button onclick="showSection('home')" class="back-button">🔙 Back to Home</button>
</section> <!-- ✅ CLOSES scheduleSessions section properly -->

<!-- ✅ ACHIEVEMENTS SECTION (now outside scheduleSessions) -->
<section id="achievements" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">🏆 Achievements</h1>
  <p class="text-gray-300 text-lg mb-10">
    Celebrate your milestones and progress throughout your study journey. Achievements are unlocked based on your activity and quiz performance.
  </p>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

    <!-- Achievement 1 -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-blue-600/40 transition-all duration-300">
      <h2 class="text-2xl font-semibold text-blue-300 mb-2">🎯 Quick Starter</h2>
      <p class="text-gray-400">Created your first reviewer.</p>
    </div>

    <!-- Achievement 2 -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-blue-600/40 transition-all duration-300">
      <h2 class="text-2xl font-semibold text-blue-300 mb-2">📚 Study Streak</h2>
      <p class="text-gray-400">Completed study sessions for 5 days in a row.</p>
    </div>

    <!-- Achievement 3 -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-blue-600/40 transition-all duration-300">
      <h2 class="text-2xl font-semibold text-blue-300 mb-2">🧠 Quiz Master</h2>
      <p class="text-gray-400">Scored 90% or higher on any quiz.</p>
    </div>

    <!-- Achievement 4 -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-blue-600/40 transition-all duration-300">
      <h2 class="text-2xl font-semibold text-blue-300 mb-2">📈 Consistent Learner</h2>
      <p class="text-gray-400">Tracked progress across all 5 subjects.</p>
    </div>

    <!-- Achievement 5 -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-blue-600/40 transition-all duration-300">
      <h2 class="text-2xl font-semibold text-blue-300 mb-2">🚀 Upload Hero</h2>
      <p class="text-gray-400">Uploaded at least 10 files to your study library.</p>
    </div>

    <!-- Achievement 6 -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-6 rounded-2xl shadow-lg hover:shadow-blue-600/40 transition-all duration-300">
      <h2 class="text-2xl font-semibold text-blue-300 mb-2">🏅 All-Rounder</h2>
      <p class="text-gray-400">Completed a quiz in every subject category.</p>
    </div>

  </div>

  <button onclick="showSection('home')" class="back-button">🔙 Back to Home</button>
</section>


<!-- UPLOAD & ORGANIZE SECTION -->
<section id="uploadOrganize" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">📁 Upload & Organize Materials</h1>
  <p class="text-gray-300 text-lg mb-10">
    Easily upload study materials, notes, and documents. Files are automatically categorized by subject for faster access.
  </p>

  <!-- Upload Form -->
  <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg mb-8 max-w-2xl mx-auto">
    <form id="uploadForm" enctype="multipart/form-data" class="space-y-6">
      <!-- Subject Dropdown -->
      <div>
        <label class="block text-gray-300 font-semibold mb-2">📘 Subject</label>
        <select id="subjectSelect" name="subject" required 
                class="w-full bg-gray-900 border border-gray-700 text-gray-200 p-3 rounded-lg focus:ring focus:ring-blue-500">
          <option value="">-- Select Subject --</option>
          <option>🐍 Python Fundamentals</option>
          <option>🌐 HTML & CSS Fundamentals</option>
          <option>💻 PHP Fundamentals</option>
          <option>☕ Java Fundamentals</option>
          <option>🖧 Networking Fundamentals</option>
        </select>
      </div>

      <!-- File Upload -->
      <div>
        <label class="block text-gray-300 font-semibold mb-2">📂 Choose File</label>
        <input type="file" id="fileInput" name="file" required
               class="w-full bg-gray-900 border border-gray-700 text-gray-200 p-3 rounded-lg focus:ring focus:ring-blue-500">
      </div>

      <!-- Upload Button -->
      <button type="button" onclick="uploadFile()" 
              class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition">
        ⬆️ Upload File
      </button>
    </form>
  </div>

  <!-- Uploaded Files List -->
  <div id="uploadedFilesContainer" class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-semibold text-blue-300 mb-4">📋 Organized Files</h2>
    <div id="fileList" class="space-y-4 text-gray-300">
      <p class="italic text-gray-500">No files uploaded yet.</p>
    </div>
  </div>

  <button onclick="showSection('home')" class="back-button mt-10">🔙 Back to Home</button>
</section>


<!-- MY REVIEWERS SECTION -->
<section id="myReviewers" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">📚 My Reviewers</h1>
  <p class="text-gray-300 text-lg mb-10">
    Access all your saved reviewers, practice tests, and summaries in one place for quick study sessions.
  </p>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    
    <!-- Saved Reviewers -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
      <h2 class="text-2xl font-semibold text-blue-300 mb-2">📖 Saved Reviewers</h2>
      <p class="text-gray-400 mb-4">Browse all your saved reviewer files and notes organized by subject.</p>
      <button onclick="alert('This will open your saved reviewers.')" 
              class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition">📂 Open Reviewers</button>
    </div>

    <!-- Practice Tests -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
      <h2 class="text-2xl font-semibold text-blue-300 mb-2">🧠 Practice Tests</h2>
      <p class="text-gray-400 mb-4">View and retake practice quizzes you've completed before.</p>
      <button onclick="alert('This will open your saved practice tests.')" 
              class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg transition">📝 View Tests</button>
    </div>

    <!-- Summaries -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-2xl shadow-lg hover:shadow-blue-600/40 hover:-translate-y-2 transition-all duration-300">
      <h2 class="text-2xl font-semibold text-blue-300 mb-2">🧾 Summaries</h2>
      <p class="text-gray-400 mb-4">Quickly review short summaries or key points from your study materials.</p>
      <button onclick="alert('This will open your summaries.')" 
              class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-6 rounded-lg transition">📋 Open Summaries</button>
    </div>

  </div>

  <button onclick="showSection('home')" class="back-button mt-10">🔙 Back to Home</button>
</section>


<!-- STUDY TRACKER SECTION -->
<section id="studyTracker" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-8 text-blue-400">📊 Study Tracker</h1>
  <p class="text-gray-300 text-lg mb-10">
    Track your progress with visual indicators to help you see what subjects or topics you need to review more.
  </p>

  <!-- Progress Summary -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
    
    <!-- Python Progress -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg">
      <h2 class="text-2xl font-semibold text-blue-300 mb-3">🐍 Python Fundamentals</h2>
      <div class="w-full bg-gray-900 rounded-full h-4 mb-2">
        <div id="pythonProgress" class="bg-blue-500 h-4 rounded-full" style="width: 75%;"></div>
      </div>
      <p class="text-gray-400 text-sm">Progress: <span id="pythonPercent">75%</span></p>
    </div>

    <!-- HTML & CSS Progress -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg">
      <h2 class="text-2xl font-semibold text-blue-300 mb-3">🌐 HTML & CSS Fundamentals</h2>
      <div class="w-full bg-gray-900 rounded-full h-4 mb-2">
        <div id="htmlProgress" class="bg-green-500 h-4 rounded-full" style="width: 60%;"></div>
      </div>
      <p class="text-gray-400 text-sm">Progress: <span id="htmlPercent">60%</span></p>
    </div>

    <!-- PHP Progress -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg">
      <h2 class="text-2xl font-semibold text-blue-300 mb-3">💻 PHP Fundamentals</h2>
      <div class="w-full bg-gray-900 rounded-full h-4 mb-2">
        <div id="phpProgress" class="bg-yellow-500 h-4 rounded-full" style="width: 40%;"></div>
      </div>
      <p class="text-gray-400 text-sm">Progress: <span id="phpPercent">40%</span></p>
    </div>

    <!-- Java Progress -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg">
      <h2 class="text-2xl font-semibold text-blue-300 mb-3">☕ Java Fundamentals</h2>
      <div class="w-full bg-gray-900 rounded-full h-4 mb-2">
        <div id="javaProgress" class="bg-purple-500 h-4 rounded-full" style="width: 50%;"></div>
      </div>
      <p class="text-gray-400 text-sm">Progress: <span id="javaPercent">50%</span></p>
    </div>

    <!-- Networking Progress -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg">
      <h2 class="text-2xl font-semibold text-blue-300 mb-3">🖧 Networking Fundamentals</h2>
      <div class="w-full bg-gray-900 rounded-full h-4 mb-2">
        <div id="networkProgress" class="bg-red-500 h-4 rounded-full" style="width: 30%;"></div>
      </div>
      <p class="text-gray-400 text-sm">Progress: <span id="networkPercent">30%</span></p>
    </div>

  </div>

  <!-- Buttons -->
  <div class="mt-10 flex justify-between">
    <button onclick="resetProgress()" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold shadow-lg transition">🔄 Reset Progress</button>
    <button onclick="showSection('home')" class="back-button">🔙 Back to Home</button>
  </div>
</section>

<script>
// Optional: dynamically update or reset progress (you can expand this logic later)
function resetProgress() {
  const subjects = [
    { id: 'pythonProgress', percent: 'pythonPercent' },
    { id: 'htmlProgress', percent: 'htmlPercent' },
    { id: 'phpProgress', percent: 'phpPercent' },
    { id: 'javaProgress', percent: 'javaPercent' },
    { id: 'networkProgress', percent: 'networkPercent' }
  ];

  subjects.forEach(sub => {
    document.getElementById(sub.id).style.width = '0%';
    document.getElementById(sub.percent).textContent = '0%';
  });

  alert("📉 All progress has been reset. Time to start studying again!");
}
</script>

<!-- STUDY COACH RECOMMENDATIONS SECTION -->
<section id="recommendations" class="hidden p-10">
  <h1 class="text-4xl font-bold mb-6 text-blue-400">🤖 Study Coach Recommendations</h1>
  <p class="text-gray-300 text-lg mb-8">
    Get personalized study tips and subject focus recommendations based on your recent activity and progress.
  </p>

  <!-- Recommendation Box -->
  <div id="recommendationBox" class="bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-xl mb-8">
    <h2 class="text-2xl font-semibold text-blue-300 mb-4">📊 Your Personalized Study Focus</h2>
    <p id="recommendationText" class="text-gray-200 text-lg italic">
      Click the button below to generate your personalized study recommendations.
    </p>

    <button onclick="generateRecommendations()" 
            class="mt-6 px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold shadow-lg transition-all duration-300">
      🎯 Get Recommendations
    </button>
  </div>

  <!-- Suggested Study Plan -->
  <div id="studyPlan" class="hidden bg-gradient-to-br from-gray-800 to-gray-700 p-8 rounded-3xl shadow-lg mt-8">
    <h3 class="text-2xl font-semibold text-blue-300 mb-4">📅 Suggested Study Plan</h3>
    <ul id="planList" class="list-disc pl-6 text-gray-200 space-y-2">
      <!-- Dynamic content -->
    </ul>
  </div>

  <button onclick="showSection('home')" class="back-button mt-10">🔙 Back to Home</button>
</section>




</main>

<!-- Tailwind Reusable Classes -->
<style>
.subject-link {
  display: block;
  background: #1f2937;
  padding: 1.5rem;
  border-radius: 0.75rem;
  transition: all 0.3s;
  box-shadow: 0 0 10px rgba(59,130,246,0.2);
}
.subject-link:hover {
  background: #374151;
  transform: translateY(-5px);
  box-shadow: 0 0 20px rgba(59,130,246,0.4);
}
.back-button {
  margin-top: 3rem;
  color: #60a5fa;
  font-weight: 600;
  transition: 0.3s;
}
.back-button:hover {
  color: #3b82f6;
}
</style>

<script>
// Show and hide sections dynamically
function showSection(id) {
  document.querySelectorAll('main section').forEach(sec => sec.classList.add('hidden'));
  const target = document.getElementById(id);
  if (target) target.classList.remove('hidden');
}

// Toggle subject dropdown
function toggleSubjects() {
  const list = document.getElementById('subjectList');
  const arrow = document.getElementById('arrow');
  list.classList.toggle('hidden');
  arrow.classList.toggle('rotate-180');
}
</script>
<script>
let timerInterval;
let totalSeconds = 0;
let isRunning = false;

function toggleTimer() {
  document.getElementById("floatingTimer").classList.toggle("hidden");
}

function minimizeTimer() {
  document.getElementById("floatingTimer").classList.add("hidden");
  document.getElementById("minimizedTimer").classList.remove("hidden");
}

function restoreTimer() {
  document.getElementById("minimizedTimer").classList.add("hidden");
  document.getElementById("floatingTimer").classList.remove("hidden");
}

function startTimer() {
  const hours = parseInt(document.getElementById("hoursInput").value) || 0;
  const minutes = parseInt(document.getElementById("minutesInput").value) || 0;
  const seconds = parseInt(document.getElementById("secondsInput").value) || 0;

  totalSeconds = hours * 3600 + minutes * 60 + seconds;

  if (totalSeconds <= 0) {
    alert("Please enter a valid time!");
    return;
  }

  clearInterval(timerInterval);
  isRunning = true;
  updateDisplays();

  timerInterval = setInterval(() => {
    if (totalSeconds > 0) {
      totalSeconds--;
      updateDisplays(); 
    } else {
      clearInterval(timerInterval);
      isRunning = false;
      alert("⏰ Time’s up! Take a short break.");
    }
  }, 1000);
}

function resetTimer() {
  clearInterval(timerInterval);
  isRunning = false;
  totalSeconds = 0;
  updateDisplays();
  document.getElementById("hoursInput").value = "";
  document.getElementById("minutesInput").value = "";
  document.getElementById("secondsInput").value = "";
}

function updateDisplays() {
  const hours = Math.floor(totalSeconds / 3600);
  const minutes = Math.floor((totalSeconds % 3600) / 60);
  const seconds = totalSeconds % 60;

  const formattedTime = 
    `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

  document.getElementById("timerDisplay").textContent = formattedTime;
  document.getElementById("miniDisplay").textContent = formattedTime;
}
</script>

<script>
// --- Upload & Organize logic ---
function uploadFile() {
  const subject = document.getElementById("subjectSelect").value;
  const fileInput = document.getElementById("fileInput");
  const fileList = document.getElementById("fileList");

  if (!subject) {
    alert("Please select a subject!");
    return;
  }

  if (fileInput.files.length === 0) {
    alert("Please choose a file to upload!");
    return;
  }

  const file = fileInput.files[0];
  
  // Simulate upload success (no backend needed for now)
  const fileItem = document.createElement("div");
  fileItem.classList.add("bg-gray-800", "p-4", "rounded-xl", "shadow-md", "flex", "justify-between", "items-center");

  fileItem.innerHTML = `
    <div>
      <p class="font-semibold text-blue-400">${file.name}</p>
      <p class="text-sm text-gray-400">📘 ${subject}</p>
    </div>
    <button class="text-red-400 hover:text-red-600 transition" onclick="this.parentElement.remove()">🗑️ Delete</button>
  `;

  // Replace “no files” message if present
  if (fileList.querySelector("p")) fileList.innerHTML = "";
  fileList.appendChild(fileItem);

  // Clear inputs
  document.getElementById("uploadForm").reset();
  
  alert(`✅ "${file.name}" uploaded under ${subject}`);
}
</script>

<script>
function generateRecommendations() {
  const recommendationText = document.getElementById("recommendationText");
  const studyPlan = document.getElementById("studyPlan");
  const planList = document.getElementById("planList");

  // Simulate analysis of user's recent activity
  const subjects = [
    { name: "🐍 Python Fundamentals", score: Math.floor(Math.random() * 100) },
    { name: "🌐 HTML & CSS Fundamentals", score: Math.floor(Math.random() * 100) },
    { name: "💻 PHP Fundamentals", score: Math.floor(Math.random() * 100) },
    { name: "☕ Java Fundamentals", score: Math.floor(Math.random() * 100) },
    { name: "🖧 Networking Fundamentals", score: Math.floor(Math.random() * 100) }
  ];

  const weakest = subjects.sort((a, b) => a.score - b.score)[0];
  const strongest = subjects.sort((a, b) => b.score - a.score)[0];

  recommendationText.innerHTML = `
    Based on your recent study activity, your <span class="text-red-400 font-semibold">
    weakest subject</span> appears to be <span class="text-yellow-300 font-semibold">
    ${weakest.name}</span>. 
    Your <span class="text-green-400 font-semibold">strongest subject</span> is 
    <span class="text-green-300 font-semibold">${strongest.name}</span>.
    Focus on improving your weaker areas for better balance! 💪
  `;

  // Suggested study plan
  const planItems = [
    `🗓️ Spend at least 30 minutes reviewing ${weakest.name} materials daily.`,
    `🧠 Take a short quiz on ${weakest.name} every 2 days to track progress.`,
    `📘 Reinforce your strengths by creating a new reviewer for ${strongest.name}.`,
    `💡 Try a mixed quiz including both ${weakest.name} and ${strongest.name} for better retention.`,
    `☕ Take short breaks and track your sessions in the Study Tracker to avoid burnout.`
  ];

  planList.innerHTML = planItems.map(item => `<li>${item}</li>`).join("");
  studyPlan.classList.remove("hidden");
}
</script>


<script>
async function uploadFile() {
  const formData = new FormData();
  const subject = document.getElementById('subjectSelect').value;
  const file = document.getElementById('fileInput').files[0];

  if (!subject || !file) {
    alert("⚠️ Please select a subject and a file before uploading.");
    return;
  }

  formData.append('subject', subject);
  formData.append('file', file);

  const response = await fetch('upload.php', {
    method: 'POST',
    body: formData
  });

  const result = await response.json();

  if (result.success) {
    alert(`✅ ${result.message}`);
    const fileList = document.getElementById('fileList');
    const noFilesMsg = fileList.querySelector('p');
    if (noFilesMsg) noFilesMsg.remove();

    const newItem = document.createElement('div');
    newItem.className = "bg-gray-800 p-4 rounded-xl border border-gray-700";
    newItem.innerHTML = `
      <strong>${result.filename}</strong> 
      <span class="text-gray-400 text-sm">(${result.subject})</span>
    `;
    fileList.appendChild(newItem);

    document.getElementById('uploadForm').reset();
  } else {
    alert("❌ Upload failed: " + result.message);
  }
}
</script>



</body>
</html>  