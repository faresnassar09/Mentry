@extends('users.layouts.app')
@section('title','الصفحة الرئيسية')
@section('content')

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>Circle Countdown Timer</title>
  <style>
    .timer-wrapper {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-left: 100px;
    }

    .timer-container {
      position: relative;
      width: 200px;
      height: 200px;
    }

    .circle-bg {
      fill: none;
      stroke: #eee;
      stroke-width: 15;
    }

    .circle-progress {
      fill: none;
      stroke: #007bff;
      stroke-width: 15;
      stroke-linecap: round;
      transition: stroke-dashoffset 0.5s;
    }

    .time-display {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 2rem;
      font-weight: bold;
    }

    .inputs {
      margin-left: 100px;
    }

    .inputs input {
      width: 80px;
      padding: 5px;
      font-size: 1rem;
      margin: 0 10px;
      text-align: center;
    }

    .set_time {
      padding: 10px 20px;
      font-size: 1rem;
      cursor: pointer;
      border: none;
      background-color: #007bff;
      color: white;
      border-radius: 5px;
    }

    .set_time:hover {
      background-color: #0056b3;
    }

    .reset_btn {
      padding: 5px 5px;
      font-size: 1.2rem;
      border: none;
      background-color:green;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    .reset_btn:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>

<audio id="endSound" src="{{Storage::url('end_timer.mp3')}}" preload="auto"></audio>

<div class="inputs">
  <input type="number" id="hours" placeholder="ساعات" min="0" max="24">
  <input type="number" id="minutes" placeholder="دقائق" min="0" max="59">
  <button class="set_time" onclick="startTimer()">ابدا</button>
</div>

<div class="timer-wrapper">
  <div class="timer-container">
    <svg width="200" height="200">
      <circle class="circle-bg" cx="100" cy="100" r="85" />
      <circle class="circle-progress" id="progressCircle" cx="100" cy="100" r="85" />
    </svg>
    <div class="time-display" id="timeDisplay">00:00</div>
  </div>

  <button class="reset_btn" onclick="resetTimer()">اعادة</button>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
  <a href="{{route('users.study.books.index')}}" class="bg-white rounded-2xl shadow p-4 flex items-center justify-between hover:shadow-lg transition">
    <div>
      <h3 class="text-gray-500 text-sm">كتب الدراسة</h3>
      <p class="text-2xl font-bold text-gray-800">{{$data['studyBooksCount']}}</p>
    </div>
    <div class="text-blue-500 text-3xl">📚</div>
  </a>

  <a href="{{route('users.writing.books.index')}}" class="bg-white rounded-2xl shadow p-4 flex items-center justify-between hover:shadow-lg transition">
    <div>
      <h3 class="text-gray-500 text-sm">الكتب التي كتبتها</h3>
      <p class="text-2xl font-bold text-gray-800">{{$data['userBooks']}}</p>
    </div>
    <div class="text-green-500 text-3xl">✍️</div>
  </a>

  <!-- ملازمي -->
  <a href="{{route('users.study.materials.index')}}" class="bg-white rounded-2xl shadow p-4 flex items-center justify-between hover:shadow-lg transition">
    <div>
      <h3 class="text-gray-500 text-sm">ملازمي</h3>
      <p class="text-2xl font-bold text-gray-800">{{$data['studyMiniBooks']}}</p>
    </div>
    <div class="text-yellow-500 text-3xl">🗂️</div>
  </a>

  <!-- ملخصاتي -->
  <a href="{{route('users.study.materials.index')}}" class="bg-white rounded-2xl shadow p-4 flex items-center justify-between hover:shadow-lg transition">
    <div>
      <h3 class="text-gray-500 text-sm">ملخصاتي</h3>
      <p class="text-2xl font-bold text-gray-800">{{$data['studySummers']}}</p>
    </div>
    <div class="text-pink-500 text-3xl">📝</div>
  </a>

  <a href="{{route('users.writing.notes.index')}}" class="bg-white rounded-2xl shadow p-4 flex items-center justify-between hover:shadow-lg transition">
    <div>
      <h3 class="text-gray-500 text-sm">ملاحظاتي</h3>
      <p class="text-2xl font-bold text-gray-800">{{$data['userNotes']}}</p>
    </div>
    <div class="text-purple-500 text-3xl">🗒️</div>
  </a>

  <a href="{{route('users.writing.snippets.index')}}" class="bg-white rounded-2xl shadow p-4 flex items-center justify-between hover:shadow-lg transition">
    <div>
      <h3 class="text-gray-500 text-sm">مقتطفاتي</h3>
      <p class="text-2xl font-bold text-gray-800">{{$data['userSnippets']}}</p>
    </div>
    <div class="text-indigo-500 text-3xl">💡</div>
  </a>

  <!-- كتب متوفرة للقراءة -->
  <a href="{{route('reading.books.index')}}" class="bg-white rounded-2xl shadow p-4 flex items-center justify-between hover:shadow-lg transition">
    <div>
      <h3 class="text-gray-500 text-sm">كتب متوفرة للقراءة</h3>
      <p class="text-2xl font-bold text-gray-800">{{$data['readingBooks']}}</p>
    </div>
    <div class="text-red-500 text-3xl">📖</div>
  </a>
</div>

<script>
  let totalSeconds = 0;
  let currentSeconds = 0;
  let interval = null;

  const circle = document.getElementById('progressCircle');
  const timeDisplay = document.getElementById('timeDisplay');
  const radius = 85;
  const circumference = 2 * Math.PI * radius;
  circle.style.strokeDasharray = `${circumference}`;
  circle.style.strokeDashoffset = `${circumference}`;

  // استرجاع الوقت عند تحميل الصفحة
  window.onload = () => {
    const savedEndTime = sessionStorage.getItem('endTime');
    if (savedEndTime) {
      const now = Math.floor(Date.now() / 1000);
      const endTime = parseInt(savedEndTime);
      const remaining = endTime - now;
      if (remaining > 0) {
        totalSeconds = remaining;
        currentSeconds = remaining;
        startInterval();
      } else {
        sessionStorage.removeItem('endTime');
      }
    }
  };

  function updateCircle(progress) {
    const offset = circumference - progress * circumference;
    circle.style.strokeDashoffset = offset;
  }

  function formatTime(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
  }

  function startTimer() {
    const hours = parseInt(document.getElementById('hours').value) || 0;
    const minutes = parseInt(document.getElementById('minutes').value) || 0;
    totalSeconds = (hours * 60 + minutes) * 60;
    if (totalSeconds <= 0) return;

    currentSeconds = totalSeconds;

    const endTime = Math.floor(Date.now() / 1000) + totalSeconds;
    sessionStorage.setItem('endTime', endTime);

    if (interval) clearInterval(interval);
    startInterval();
  }

  function startInterval() {
    updateCircle(1);
    timeDisplay.textContent = formatTime(currentSeconds);

    interval = setInterval(() => {
      if (currentSeconds <= 0) {
        clearInterval(interval);
        updateCircle(0);
        timeDisplay.textContent = "00:00";
        sessionStorage.removeItem('endTime');
        const endSound = document.getElementById('endSound');
        endSound.play();
        return;
      }

      currentSeconds--;
      timeDisplay.textContent = formatTime(currentSeconds);
      updateCircle(currentSeconds / totalSeconds);
    }, 1000);
  }

  function resetTimer() {
    clearInterval(interval);
    totalSeconds = 0;
    currentSeconds = 0;
    updateCircle(0);
    timeDisplay.textContent = "00:00";
    sessionStorage.removeItem('endTime');
  }
</script>

</body>
</html>

@endsection
