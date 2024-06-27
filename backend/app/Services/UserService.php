<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Exception;
use App\Models\User;
use App\Models\Wallet;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    protected $user;
    protected $faker;
    protected $wallet;

    public function __construct(User $user, Faker $faker, Wallet $wallet)
    {
        $this->user = $user;
        $this->faker = $faker;
        $this->wallet = $wallet;
    }

    /**
     * Hàm lấy ra thông tin của tất cả người dùng
     * @return $users
     */
    public function getAllUsers()
    {
        try {
            Log::info('Fetching all users');

            return UserResource::collection($this->user->all());
        } catch (Exception $e) {
            Log::error('Failed to fetch users: ' . $e->getMessage());

            throw new Exception('Failed to fetch users');
        }
    }

    /**
     * Hàm lấy ra thông tin của người dùng theo id
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function getUserById(int $id): UserResource
    {
        Log::info("Fetching user with ID: $id");
        $user = $this->user->find($id);

        if (!$user) {
            Log::warning("User with ID: $id not found");
            throw new ModelNotFoundException("User not found");
        }

        return UserResource::make($user);
    }

    /**
     * Hàm tạo mới người dùng
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        DB::beginTransaction();

        try {
            Log::info("Creating a new user with email: {$data['email']}");
            $user = $this->user->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'address' => @$data['address'],
                'referral_code' => $this->randomReferralCode(),
                'referrer_id' => $data['referrer_id'],
                'phone' => @$data['phone'],
                'role_id' => $data['role_id'],
                'status' => $data['status'],
            ]);

            $wallets = $this->wallet->all()->pluck('id')->toArray();
            foreach ($wallets as $wallet) {
                $user->wallet()->attach($wallet);
            }
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to create user: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Cập nhật thông tin người dùng
     *
     * @param int $id
     * @param array $data
     * @return User
     * @throws ModelNotFoundException
     */
    public function updateUser(User $user, array $data): User
    {
        DB::beginTransaction();

        try {
            Log::info("Updating user with ID: $user->id");
            $user->update($data);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to update user: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Xóa người dùng
     *
     * @param int $id
     * @throws ModelNotFoundException
     */
    public function deleteUser(int $id): void
    {
        DB::beginTransaction();

        try {
            $user = $this->getUserById($id);

            Log::info("Deleting user with ID: $id");
            $user->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to delete user: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Random mã giới thiệu
     *
     * @param void
     * @return $rand
     */
    protected function randomReferralCode()
    {
        $rand =  "PTIT" . $this->faker->numberBetween(10000000, 99999999);

        $exist_user = User::where('referral_code', $rand)->exists();
        while ($exist_user) {
            $this->randomReferralCode();
        }

        return $rand;
    }
}
