<?php
class SlugGenerator {
    public static function generateSlug(string $title): string {
        // Convertir en minuscules
        $slug = strtolower($title);

        // Remplacer les espaces par des tirets
        $slug = str_replace(' ', '-', $slug);

        // Supprimer les caractères non alphanumériques
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

        return $slug;
    }
}
?>