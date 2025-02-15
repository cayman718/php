<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆</title>
    <style>
        body {
            background-color: #E6E6FA; /* 薰衣草紫背景 */
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            color: #6A1B9A; /* 深紫色文字 */
        }

        /* 標題區域 */
        h1 {
            color: #6A1B9A; /* 深紫色 */
            font-size: 3em;
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        /* 月份選擇器 */
        select {
            font-size: 16px;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #D1C4E9; /* 淡紫色 */
            border: 1px solid #B39DDB;
            transition: background-color 0.3s;
            margin: 0 10px;
        }

        select:hover {
            background-color: #9C27B0; /* 懸停時使用深紫色 */
            color: white;
        }

        /* 主體容器 */
        .nav {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* 月份導航 */
        .month-title {
            font-size: 36px;
            color: #6A1B9A; /* 深紫色 */
            font-weight: bold;
            text-align: center;
            flex-grow: 1;
        }

        /* 表格區域 */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: center;
        }

        /* 日期格子 */
        td {
            background-color: #FFFFFF; /* 白色背景 */
            padding: 20px 10px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* 輕微陰影 */
            transition: transform 0.3s, background-color 0.3s;
            position: relative;
        }

        td:hover {
            background-color: #D1C4E9; /* 淡紫色懸停效果 */
            transform: scale(1.05); /* 放大效果 */
        }

        /* 當天日期 */
        .today {
            background-color: #9C27B0; /* 深紫色 */
            color: white;
            font-weight: bold;
            padding: 10px 16px;
            font-size: 1.2em;
            border-radius: 18px;
            box-shadow: 0 0 6px rgba(156, 39, 176, 0.3);
            animation: pulse 2s infinite;
        }

        /* 日期容器 */
        .date-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* 日期顯示 */
        .date {
            font-size: 24px;
            color: #6A1B9A; /* 深紫色 */
            font-weight: normal;
            margin-bottom: 10px;
        }

        /* 淺灰色日期（非當月日期） */
        .grey-text {
            color: #B0BEC5; /* 淺灰色 */
            opacity: 0.6; /* 淡化效果 */
        }

        /* 節慶日期 */
        .event {
            background-color: #F8BBD0; /* 淺粉紅色 */
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            margin-top: 5px;
            text-align: center;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        /* 特殊日期 */
        .holiday {
            background: #F48FB1; /* 溫柔的玫瑰紅色 */
            color: white;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        /* 排版調整：強調周六和周日 */
        table td:nth-child(1), table td:nth-child(7) {
            color: #E74C3C; /* 強調周日和周六，使用紅色 */
            font-weight: bold;
        }

        /* 當天日期的閃爍動畫 */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 6px rgba(156, 39, 176, 0.3);
            }
            50% {
                box-shadow: 0 0 12px rgba(156, 39, 176, 0.7);
            }
            100% {
                box-shadow: 0 0 6px rgba(156, 39, 176, 0.3);
            }
        }
    </style>
</head>
<body>
    <h1>萬年曆</h1>

    <?php

    if (isset($_GET['month'])) {
        $month = $_GET['month'];
    } else {
        $month = date("m");
    }
    if (isset($_GET['year'])) {
        $year = $_GET['year'];
    } else {
        $year = date("Y");
    }

    if ($month - 1 < 1) {
        $prevMonth = 12;
        $prevYear = $year - 1;
    } else {
        $prevMonth = $month - 1;
        $prevYear = $year;
    }

    if ($month + 1 > 12) {
        $nextMonth = 1;
        $nextYear = $year + 1;
    } else {
        $nextMonth = $month + 1;
        $nextYear = $year;
    }

    // 節慶活動日期及名稱
    $holidays = [
        '01-01' => "元旦",
        '02-10' => "農曆新年",
        '04-04' => "兒童節",
        '04-05' => "清明節",
        '05-01' => "勞動節",
        '10-10' => "國慶日",
        '06-14' => "端午節", 
        '09-20' => "中秋節", 
        '12-25' => "聖誕節", 
    ];

    $spDate = [
        '2024-11-07' => "立冬",
        '2024-11-22' => "小雪"
    ];

    ?>

    <div class="nav">
        <table style="width: 100%">
            <tr>
                <td style="text-align:left">
                    <a href="calendar.php?year=<?= $year - 1; ?>&month=<?= $month; ?>">前年</a>
                    <a href="calendar.php?year=<?= $prevYear; ?>&month=<?= $prevMonth; ?>">上一個月</a>
                </td>    
                <td style="font-size:40px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif" class="month-title">
                    <?php echo $year . "年" . date("m月", strtotime("{$year}-{$month}-01")); ?>
                </td>
                <td style="text-align:right">
                    <a href="calendar.php?year=<?= $nextYear; ?>&month=<?= $nextMonth; ?>">下一個月</a>
                    <a href="calendar.php?year=<?= $year + 1; ?>&month=<?= $month; ?>">明年</a>
                </td>
            </tr>
        </table>
    </div>

    <table>
    <tr>
        <td>日</td>
        <td>一</td>
        <td>二</td>
        <td>三</td>
        <td>四</td>
        <td>五</td>
        <td>六</td>
    </tr>

    <?php

    $firstDay = "{$year}-{$month}-1";
    $firstDayTime = strtotime($firstDay);
    $firstDayWeek = date("w", $firstDayTime);

    for ($i = 0; $i < 6; $i++) {
        echo "<tr>";
        for ($j = 0; $j < 7; $j++) {
            $cell = $i * 7 + $j - $firstDayWeek;
            $theDayTime = strtotime("$cell days" . $firstDay);

            $theMonth = (date("m", $theDayTime) == date("m", $firstDayTime)) ? '' : 'grey-text'; 
            $isToday = (date("Y-m-d", $theDayTime) == date("Y-m-d")) ? 'today' : ''; 

            echo "<td class='$theMonth $isToday'>";  
            echo "<div class='date-container'>";
            echo "<div class='date'>" . date("d", $theDayTime) . "</div>";  

            $formattedDate = date('m-d', $theDayTime);
            if (isset($holidays[$formattedDate])) {
                echo "<div class='event'>{$holidays[$formattedDate]}</div>";  
            }

            if (isset($spDate[date('Y-m-d', $theDayTime)])) {
                echo "<div class='event'>{$spDate[date('Y-m-d', $theDayTime)]}</div>";
            }
            echo "</div>";
            echo "</td>";
        }
        echo "</tr>";
    }

    ?>
    </table>
</body>
</html>
