<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {

    protected $table = 'user_access';

    protected $primaryKey = 'RecID';

    protected $returnType = 'array';

    protected $allowedFields = [
        'firtname',
        'lastname',
        'email',
        'username',
        'middlename',
        'password',
        'user_type',
        'phone_number',
        'lat',
        'lang',
        'Status',
        'created_at',
        'OtpCode',
        'OtpDate',
        'address_id'
    ];
    
}

?>