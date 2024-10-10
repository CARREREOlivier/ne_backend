<?php
declare(strict_types=1);

require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dto/UserDTO.php';

class UserRepository {
    private UserDAO $userDAO;

    public function __construct(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    public function findAll(): array {
        $users = $this->userDAO->findAll();
        return array_map(fn($user) => UserDTO::fromArray($user), $users);
    }

    public function findById(int $id): ?UserDTO {
        $user = $this->userDAO->findById($id);
        return $user ? UserDTO::fromArray($user) : null;
    }

    public function findByEmail(string $email): ?UserDTO {
        $user = $this->userDAO->findByEmail($email);
        return $user ? UserDTO::fromArray($user) : null;
    }

    public function create(UserDTO $userDTO): bool {
        return $this->userDAO->create(
            $userDTO->username,
            $userDTO->email,
            $userDTO->password,
            $userDTO->date_of_birth,
            $userDTO->description,
            $userDTO->slug
        );
    }

    public function update(UserDTO $userDTO): bool {
        return $this->userDAO->update(
            $userDTO->id,
            $userDTO->username,
            $userDTO->email,
            $userDTO->password,
            $userDTO->banStatus,
            $userDTO->date_of_birth,
            $userDTO->theme_preference,
            $userDTO->description,
            $userDTO->slug,
            $userDTO->validated_by_admin
        );
    }

    public function delete(int $id): bool {
        return $this->userDAO->delete($id);
    }
}
?>
