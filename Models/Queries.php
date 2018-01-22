<?php
class Queries
{
    /**
     * @param $dbh PDO with connection established
     * @param $query string query string with no data to be prepared
     * @param $data array  data to perform query with
     * @return array returned by fechAll() containing all result rows
     * @throws invalidDataException
     */
    public static function performQuery($dbh, $query, $data)
    {
        if (!self::validateData($data)) {
            require_once __DIR__ . "DataExceptions/invalidDataException";
            throw new invalidDataException();
        }

        $stmt = $dbh->prepare($query);
        if ($data != null) {
            $stmt->execute($data);
        } else {
            $stmt->execute();
        }
        return $stmt->fetchAll();
    }

    private static function validateData($data)
    {
        if($data == NULL)
            return true;
        foreach ($data as $elmnt) {
            if (self::length($elmnt) == 0) {
                return false;
            }
        }
        return true;
    }

    private static function length($str)
    {
        return strlen(utf8_decode($str));
    }
}
