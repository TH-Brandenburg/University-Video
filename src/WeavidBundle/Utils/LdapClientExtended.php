<?php
namespace WeavidBundle\Utils;

use ReflectionClass;
use Symfony\Component\Ldap\LdapClient;

class LdapClientExtended extends LdapClient
{

    public function findParsed($dn, $query, $filter = "*")
    {
        $result = $this->find($dn, $query, $filter)[0];

        $account['firstName'] = $result['givenname'][0];
        $account['lastName'] = $result['sn'][0];
        switch($result['fh-geschlecht'][0]){
            case "M":
                $account['gender'] = 1;
                break;
            case "W":
                $account['gender'] = 2;
                break;
            default:
                $account['gender'] = 0;
                break;
        }
        $account['email'] = $result['mail'][0];

        return $account;

    }
}