<?php
require_once("connexion.php");
class Calendar
{
    public int $day;
    public int $month;
    public int $year;

    public function __construct(int $day, int $month, int $year)
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    public function generateCalendar($rdv_dates)
    {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
          <title>Title of the document</title>
        </head>
        </html>';

        echo "<div class ='calendar'>";
        echo "<h2 style ='margin-bottom: 4% ; '>" . date('F Y', mktime(0, 0, 0, $this->month, 1, $this->year)) . "</h2>";
        echo "<button class ='move_calendar'onclick=\"changeMonth(-1)\"><i class='fa-solid fa-arrow-left'></i></button>";
        echo "<button class ='move_calendar'onclick=\"changeMonth(1)\"><i class='fa-solid fa-arrow-right'></i> </button>";
        echo "<form id='calendarForm' method='post' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>";

        echo "<table class='calendar_table' >";
        echo "<tr><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th></tr>";
        echo "<tr>";
        $currentMonth = mktime(0, 0, 0, $this->month, 1, $this->year);
        $daysInMonth = date('t', $currentMonth);
        $firstDayOfWeek = date('N', $currentMonth);

        for ($j = 1; $j < $firstDayOfWeek; $j++) {
            echo "<td></td>";
        }
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $isRdvDay = false;

            foreach ($rdv_dates as $rdv_date) {
                $timestamp = strtotime($rdv_date);
                $day_rdv = date("d", $timestamp);

                if ($day_rdv == $day && date("Y", $timestamp) == $this->year && date("m", $timestamp) == $this->month) {
                    $isRdvDay = true;
                    break;
                }
            }

            if ($isRdvDay) {
                echo "<td style='background-color:#50acd1; color: white; cursor:pointer;' class='hidden-button' onclick=\"submitForm('{$this->year}-{$this->month}-{$day}')\">{$day}</td>";
            } else {
                echo "<td>{$day}</td>";
            }

            if (($day + $firstDayOfWeek - 1) % 7 == 0) {
                echo "</tr><tr>";
            }

        }

        echo "</tr></table>";
        echo "<input type='hidden' name='selectedDate' id='selectedDateInput'/>";
        echo "</form>";
        echo "</div>";

        echo "<script>";
        echo "function submitForm(selectedDate) {";
        echo "    document.querySelector('#selectedDateInput').value = selectedDate;";
        echo "    document.getElementById('calendarForm').submit();";
        echo "}";
        echo "function changeMonth(offset) {";
        echo "    var currentUrl = window.location.href;";
        echo "    var currentParams = new URLSearchParams(window.location.search);";
        echo "    var currentMonth = parseInt(currentParams.get('month')) || {$this->month};";
        echo "    var currentYear = parseInt(currentParams.get('year')) || {$this->year};";
        echo "    var newMonth = currentMonth + offset;";
        echo "    if (newMonth < 1) { newMonth = 12; currentYear--; }";
        echo "    if (newMonth > 12) { newMonth = 1; currentYear++; }";
        echo "    window.location.href = currentUrl.split('?')[0] + '?month=' + newMonth + '&year=' + currentYear;";
        echo "}";
        echo "</script>";
    }


}
?>