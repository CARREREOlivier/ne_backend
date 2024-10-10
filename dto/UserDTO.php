<?php
declare(strict_types=1);

class UserDTO {
    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public string $created_at;
    public string $banStatus;
    public string $date_of_birth;
    public string $theme_preference;
    public string $description;
    public string $slug;
    public string $validated_by_admin;

    public function __construct(
        int $id,
        string $username,
        string $email,
        string $password,
        string $created_at,
        string $banStatus,
        string $date_of_birth,
        string $theme_preference,
        string $description,
        string $slug,
        string $validated_by_admin
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->banStatus = $banStatus;
        $this->date_of_birth = $date_of_birth;
        $this->theme_preference = $theme_preference;
        $this->description = $description;
        $this->slug = $slug;
        $this->validated_by_admin = $validated_by_admin;
    }

    // Convertir un tableau associatif en UserDTO
    public static function fromArray(array $data): UserDTO {
        return new UserDTO(
            $data['id'] ?? 0,
            $data['username'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? '',
            $data['created_at'] ?? '',
            $data['banStatus'] ?? 'None',
            $data['date_of_birth'] ?? '',
            $data['theme_preference'] ?? 'light',
            $data['description'] ?? '',
            $data['slug'] ?? '',
            $data['validated_by_admin'] ?? 'pending'
        );
    }

    // Convertir un UserDTO en tableau associatif
    public function toArray(): array {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'created_at' => $this->created_at,
            'banStatus' => $this->banStatus,
            'date_of_birth' => $this->date_of_birth,
            'theme_preference' => $this->theme_preference,
            'description' => $this->description,
            'slug' => $this->slug,
            'validated_by_admin' => $this->validated_by_admin
        ];
    }
}
?>
