<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run()
    {
        DB::table('cities')->insert([

             // Andhra Pradesh
             ['name' => 'Visakhapatnam', 'state_id' => 1, 'zipcode' => '530001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Vijayawada', 'state_id' => 1, 'zipcode' => '520001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Guntur', 'state_id' => 1, 'zipcode' => '522001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Nellore', 'state_id' => 1, 'zipcode' => '524001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Tirupati', 'state_id' => 1, 'zipcode' => '517501', 'created_at' => now(), 'updated_at' => now()],
 
             // Arunachal Pradesh
             ['name' => 'Itanagar', 'state_id' => 2, 'zipcode' => '791111', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Naharlagun', 'state_id' => 2, 'zipcode' => '791110', 'created_at' => now(), 'updated_at' => now()],
 
             // Assam
             ['name' => 'Guwahati', 'state_id' => 3, 'zipcode' => '781001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Dibrugarh', 'state_id' => 3, 'zipcode' => '786001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Silchar', 'state_id' => 3, 'zipcode' => '788001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Nagaon', 'state_id' => 3, 'zipcode' => '782001', 'created_at' => now(), 'updated_at' => now()],
 
             // Bihar
             ['name' => 'Patna', 'state_id' => 4, 'zipcode' => '800001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Gaya', 'state_id' => 4, 'zipcode' => '823001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Bhagalpur', 'state_id' => 4, 'zipcode' => '812001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Muzaffarpur', 'state_id' => 4, 'zipcode' => '842001', 'created_at' => now(), 'updated_at' => now()],
 
             // Chhattisgarh
             ['name' => 'Raipur', 'state_id' => 5, 'zipcode' => '492001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Bilaspur', 'state_id' => 5, 'zipcode' => '495001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Durg', 'state_id' => 5, 'zipcode' => '491001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Korba', 'state_id' => 5, 'zipcode' => '495677', 'created_at' => now(), 'updated_at' => now()],
 
             // Goa
             ['name' => 'Panaji', 'state_id' => 6, 'zipcode' => '403001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Margao', 'state_id' => 6, 'zipcode' => '403601', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Vasco da Gama', 'state_id' => 6, 'zipcode' => '403802', 'created_at' => now(), 'updated_at' => now()],
 
             // Gujarat
             ['name' => 'Ahmedabad', 'state_id' => 7, 'zipcode' => '380001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Surat', 'state_id' => 7, 'zipcode' => '395001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Vadodara', 'state_id' => 7, 'zipcode' => '390001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Rajkot', 'state_id' => 7, 'zipcode' => '360001', 'created_at' => now(), 'updated_at' => now()],
             ['name' => 'Bhavnagar', 'state_id' => 7, 'zipcode' => '364001', 'created_at' => now(), 'updated_at' => now()],
 
    // Haryana
    ['name' => 'Chandigarh', 'state_id' => 8, 'zipcode' => '160017', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Faridabad', 'state_id' => 8, 'zipcode' => '121001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Gurgaon', 'state_id' => 8, 'zipcode' => '122001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Ambala', 'state_id' => 8, 'zipcode' => '134003', 'created_at' => now(), 'updated_at' => now()],
    
    // Himachal Pradesh
    ['name' => 'Shimla', 'state_id' => 9, 'zipcode' => '171001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Dharamshala', 'state_id' => 9, 'zipcode' => '176215', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Mandi', 'state_id' => 9, 'zipcode' => '175001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Kullu', 'state_id' => 9, 'zipcode' => '175101', 'created_at' => now(), 'updated_at' => now()],
    
    // Jharkhand
    ['name' => 'Ranchi', 'state_id' => 10, 'zipcode' => '834001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Dhanbad', 'state_id' => 10, 'zipcode' => '826001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Jamshedpur', 'state_id' => 10, 'zipcode' => '831001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Bokaro', 'state_id' => 10, 'zipcode' => '827001', 'created_at' => now(), 'updated_at' => now()],
    
    // Karnataka
    ['name' => 'Bangalore', 'state_id' => 11, 'zipcode' => '560001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Mysuru', 'state_id' => 11, 'zipcode' => '570001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Hubli', 'state_id' => 11, 'zipcode' => '580020', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Mangalore', 'state_id' => 11, 'zipcode' => '575001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Belgaum', 'state_id' => 11, 'zipcode' => '590001', 'created_at' => now(), 'updated_at' => now()],
    
    // Kerala
    ['name' => 'Thiruvananthapuram', 'state_id' => 12, 'zipcode' => '695001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Kochi', 'state_id' => 12, 'zipcode' => '682001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Kozhikode', 'state_id' => 12, 'zipcode' => '673001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Malappuram', 'state_id' => 12, 'zipcode' => '676505', 'created_at' => now(), 'updated_at' => now()],
    
    // Madhya Pradesh
    ['name' => 'Indore', 'state_id' => 13, 'zipcode' => '452001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Bhopal', 'state_id' => 13, 'zipcode' => '462001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Gwalior', 'state_id' => 13, 'zipcode' => '474001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Jabalpur', 'state_id' => 13, 'zipcode' => '482001', 'created_at' => now(), 'updated_at' => now()],
    
    // Maharashtra
    ['name' => 'Mumbai', 'state_id' => 14, 'zipcode' => '400001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Pune', 'state_id' => 14, 'zipcode' => '411001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Nagpur', 'state_id' => 14, 'zipcode' => '440001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Thane', 'state_id' => 14, 'zipcode' => '400601', 'created_at' => now(), 'updated_at' => now()],
    
    // Manipur
    ['name' => 'Imphal', 'state_id' => 15, 'zipcode' => '795001', 'created_at' => now(), 'updated_at' => now()],
    
    // Meghalaya
    ['name' => 'Shillong', 'state_id' => 16, 'zipcode' => '793001', 'created_at' => now(), 'updated_at' => now()],
    
    // Mizoram
    ['name' => 'Aizawl', 'state_id' => 17, 'zipcode' => '796001', 'created_at' => now(), 'updated_at' => now()],
    
    // Nagaland
    ['name' => 'Kohima', 'state_id' => 18, 'zipcode' => '797001', 'created_at' => now(), 'updated_at' => now()],
    
    // Odisha
    ['name' => 'Bhubaneswar', 'state_id' => 19, 'zipcode' => '751001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Cuttack', 'state_id' => 19, 'zipcode' => '753001', 'created_at' => now(), 'updated_at' => now()],
    
    // Punjab
    ['name' => 'Ludhiana', 'state_id' => 20, 'zipcode' => '141001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Amritsar', 'state_id' => 20, 'zipcode' => '143001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Jalandhar', 'state_id' => 20, 'zipcode' => '144001', 'created_at' => now(), 'updated_at' => now()],
    
    // Rajasthan
    ['name' => 'Jaipur', 'state_id' => 21, 'zipcode' => '302001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Udaipur', 'state_id' => 21, 'zipcode' => '313001', 'created_at' => now(), 'updated_at' => now()],
    
    // Sikkim
    ['name' => 'Gangtok', 'state_id' => 22, 'zipcode' => '737101', 'created_at' => now(), 'updated_at' => now()],
    
    // Tamil Nadu
    ['name' => 'Chennai', 'state_id' => 23, 'zipcode' => '600001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Coimbatore', 'state_id' => 23, 'zipcode' => '641001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Madurai', 'state_id' => 23, 'zipcode' => '625001', 'created_at' => now(), 'updated_at' => now()],
    
    // Telangana
    ['name' => 'Hyderabad', 'state_id' => 24, 'zipcode' => '500001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Warangal', 'state_id' => 24, 'zipcode' => '506002', 'created_at' => now(), 'updated_at' => now()],
    
    // Tripura
    ['name' => 'Agartala', 'state_id' => 25, 'zipcode' => '799001', 'created_at' => now(), 'updated_at' => now()],
    
    // Uttar Pradesh
    ['name' => 'Lucknow', 'state_id' => 26, 'zipcode' => '226001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Kanpur', 'state_id' => 26, 'zipcode' => '208001', 'created_at' => now(), 'updated_at' => now()],
    
    // Uttarakhand
    ['name' => 'Dehradun', 'state_id' => 27, 'zipcode' => '248001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Haridwar', 'state_id' => 27, 'zipcode' => '249401', 'created_at' => now(), 'updated_at' => now()],
    
    // West Bengal
    ['name' => 'Kolkata', 'state_id' => 28, 'zipcode' => '700001', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Siliguri', 'state_id' => 28, 'zipcode' => '734001', 'created_at' => now(), 'updated_at' => now()],
    
        // Abu Dhabi (state_id: 29)
        ['name' => 'Al Ain', 'state_id' => 29, 'zipcode' => '00001', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Mussafah', 'state_id' => 29, 'zipcode' => '00002', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Bani Yas', 'state_id' => 29, 'zipcode' => '00003', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Al Shamkha', 'state_id' => 29, 'zipcode' => '00004', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Al Wathba', 'state_id' => 29, 'zipcode' => '00005', 'created_at' => now(), 'updated_at' => now()],

        // Dubai (state_id: 30)
        ['name' => 'Jebel Ali', 'state_id' => 30, 'zipcode' => '00006', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Al Barsha', 'state_id' => 30, 'zipcode' => '00007', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Al Karama', 'state_id' => 30, 'zipcode' => '00008', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Bur Dubai', 'state_id' => 30, 'zipcode' => '00009', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Deira', 'state_id' => 30, 'zipcode' => '00010', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Dubai Marina', 'state_id' => 30, 'zipcode' => '00011', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Downtown Dubai', 'state_id' => 30, 'zipcode' => '00012', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Palm Jumeirah', 'state_id' => 30, 'zipcode' => '00013', 'created_at' => now(), 'updated_at' => now()],

        // Sharjah (state_id: 31)
        ['name' => 'Khor Fakkan', 'state_id' => 31, 'zipcode' => '00014', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Dibba Al-Hisn', 'state_id' => 31, 'zipcode' => '00015', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Al Dhaid', 'state_id' => 31, 'zipcode' => '00016', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Kalba', 'state_id' => 31, 'zipcode' => '00017', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Al Nahda', 'state_id' => 31, 'zipcode' => '00018', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Muwailih', 'state_id' => 31, 'zipcode' => '00019', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Al Qasimia', 'state_id' => 31, 'zipcode' => '00020', 'created_at' => now(), 'updated_at' => now()],
    ]);
    }
}



