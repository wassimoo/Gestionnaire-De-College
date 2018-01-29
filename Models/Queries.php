<?php
class Queries
{
    /**
     * @param $dbh PDO object with connection established
     * @param $query string query string with no data to be prepared
     * @param $data array  data to perform query with
     * @param $type string specifies query type (select,insert,modify,update,alter)
     * @return array returned by fechAll() containing all result rows if Select stmnt
     * or
     * @return boolean result of execute() function if it's an Insert stmnt
     * @throws invalidDataException
     */
    
    public static function performQuery($dbh, $query, $data, $type)
    {
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        if (!self::validateData($data)) {
            require_once __DIR__ . "/DataExceptions/invalidDataException";
            throw new invalidDataException();
        }
        if(! is_a($dbh,"PDO"))
            return false;
        
        $stmt = $dbh->prepare($query);

        if ($data != null) {
            $result = $stmt->execute($data);
        } else {
            $result = $stmt->execute();
        }


        $type = strtolower($type);

        if ($type == 'select' ) {
            return $stmt->fetchAll();
        } else
        if ($type == 'insert' || $type == 'update') {
            return $result;
        }
        else
            return false;

    }

    private static function validateData($data)
    {
        if ($data == null) {
            return true;
        }

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
