<?php

/**
 * 时间工具
 * User: GuoHao
 * Date: 15-12-16
 * Time: 下午11:43
 */

namespace Home\Api;

class DateUtil
{
    public static $weeks = array(0 => '周日', 1 => '周一', 2 => '周二', 3 => '周三', 4 => '周四', 5 => '周五', 6 => '周六');

    /**
     * 获得当前时间
     * @return bool|string
     */
    public static function now()
    {
        return date('Y-m-d H:i:s');
    }

    public static function day()
    {
        return date('Y-m-d');
    }

    /**
     * 生成预约时间数组
     * @param $day
     * @param $startTime
     * @param $endTime
     * @return array
     */
    public static function generateAppointmentTime($day, $startTime, $endTime)
    {
        $sep = 60*60;
        $startTimeStamp = strtotime($day . ' ' . $startTime);
        $endTimeStamp = strtotime($day . ' ' . $endTime);

        $sub = $endTimeStamp - $startTimeStamp;

        $times = $sub / $sep;

        $appointmentTimes = array();

        for ($i = 0; $i <= $times; $i++) {
            $appointmentTimes[date('H:i', $startTimeStamp + ($i * $sep))] = 1;
        }

        return $appointmentTimes;
    }

    /**
     * 日期+时间
     * @param $day
     * @param $time
     * @return string
     */
    public static function buildDateTime($day, $time)
    {
        return "{$day} {$time}";
    }

    /**
     * 生成制定日期后的 {$count}天
     * @param string $day
     * @param int $count
     * @return array
     */
    public static function buildDays($day = '', $count = 15)
    {
        if (!$day)
            $day = date('Y-m-d');

        $days = array();
        // 0（表示星期天）到 6（表示星期六）
        $weeks = self::$weeks;
        for ($i = 0; $i < $count; $i++) {
            $date = date('Y-m-d', strtotime("{$day} +{$i} day"));
            // 星期
            $inWeek = self::calcDayInWeek($date);
            $week = $weeks[$inWeek];

            $days[$date] = "{$date} {$week}";
        }

        return $days;
    }

    /**
     * 计算某天是周几
     * @param $day
     * @return string
     */
    public static function calcDayInWeek($day)
    {
        // array(0 => '星期天', 1 => '星期一', 2 => '星期二', 3 => '星期三', 4 => '星期四', 5 => '星期五', 6 => '星期六');
        return date('w', strtotime($day));
    }

    public static function dayInWeekName($day)
    {
        $inWeek = self::calcDayInWeek($day);
        $weeks = self::$weeks;

        return $weeks[$inWeek];
    }

    public static function inWeekName($w)
    {
        $weeks = self::$weeks;

        return $weeks[$w];
    }

    /**
     * 当前的日期大于参数
     * @param $day
     * @return bool
     */
    public static function gtDay($day)
    {
        return date('Y-m-d') > $day;
    }


    public static function getOnlyDay($date)
    {
        $time = strtotime($date);

        return date('Y-m-d', $time);
    }

} 