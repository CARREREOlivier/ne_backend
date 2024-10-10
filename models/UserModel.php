<?php
declare(strict_types=1);

class UserModel {
    public ?int $id;
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
        ?int $id = null,
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

    public function validate(): array {
        $errors = [];
        if (strlen($this->username) > 25) {
            $errors[] = "Le nom d'utilisateur ne doit pas dépasser 25 caractères.";
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }
        return $errors;
    }

    public function isValid(): bool {
        return count($this->validate()) === 0;
    }

    public static function fromArray(array $data): UserModel {
        return new UserModel(
            $data['id'] ?? null,
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
}
?>
