<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Categories
        $categories = [
            ['name' => 'Jeux de construction', 'slug' => 'construction', 'description' => 'Blocs, Lego, et autres jeux pour développer la créativité.'],
            ['name' => 'Jeux d\'extérieur, sport et loisirs', 'slug' => 'outdoor', 'description' => 'Ballons, cerfs-volants et activités en plein air.'],
            ['name' => 'Jeux de société et famille', 'slug' => 'board-games', 'description' => 'Jeux de plateau et jeux de cartes pour tous les âges.'],
            ['name' => 'Jouets d\'éveil et 1er âge', 'slug' => 'baby-toys', 'description' => 'Jouets pour bébés et tout-petits pour stimuler les sens.'],
            ['name' => 'Déguisements et costumes', 'slug' => 'costumes', 'description' => 'Costumes et accessoires pour le jeu de rôle et le carnaval.'],
            ['name' => 'Jeux éducatifs et scientifiques', 'slug' => 'educational', 'description' => 'Kits éducatifs, puzzles et activités scientifiques.'],
            ['name' => 'Offres & Promotions', 'slug' => 'offers', 'description' => 'Meilleures ventes, promotions et réductions spéciales.'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insert(array_merge($cat, [
                'created_at' => now(), 'updated_at' => now()
            ]));
        }

        // 2. Create Users (3 Admins + Normal Users)
        $admins = [
            ['name' => 'Admin One', 'email' => 'admin1@beautyhouse.com', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '1234567890'],
            ['name' => 'Admin Two', 'email' => 'admin2@beautyhouse.com', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '1234567890'],
            ['name' => 'Admin Three', 'email' => 'admin3@beautyhouse.com', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '1234567890'],
        ];

        foreach ($admins as $admin) {
            DB::table('users')->insert(array_merge($admin, [
                'email_verified_at' => now(),
                'status' => 'active',
                'created_at' => now(), 'updated_at' => now()
            ]));
        }

        $users = [
            ['name' => 'Sarah Doe', 'email' => 'sarah@example.com', 'password' => Hash::make('password'), 'role' => 'user', 'phone' => '555123456'],
            ['name' => 'Emily Rose', 'email' => 'emily@example.com', 'password' => Hash::make('password'), 'role' => 'user', 'phone' => '555987654'],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert(array_merge($user, [
                'email_verified_at' => now(),
                'status' => 'active',
                'created_at' => now(), 'updated_at' => now()
            ]));
        }

        // 3. Create Products (20+ items)
        $catIds = DB::table('categories')->pluck('id', 'slug');

        $products = [
            // Jeux de construction
            ['category_id' => $catIds['construction'], 'name' => 'Bloc de Construction Magnétique', 'slug' => 'bloc-construction-magnetique', 'price' => 30.00, 'stock' => 100, 'description' => 'Blocs magnétiques pour construire des formes créatives.'],
            ['category_id' => $catIds['construction'], 'name' => 'Lego Classic', 'slug' => 'lego-classic', 'price' => 45.00, 'stock' => 80, 'description' => 'Boîte de briques LEGO pour stimuler l’imagination.'],
        
            // Jeux d'extérieur, sport et loisirs
            ['category_id' => $catIds['outdoor'], 'name' => 'Ballon de Football', 'slug' => 'ballon-football', 'price' => 15.00, 'stock' => 150, 'description' => 'Ballon de football taille standard pour enfants.'],
            ['category_id' => $catIds['outdoor'], 'name' => 'Cerf-volant Coloré', 'slug' => 'cerf-volant-colore', 'price' => 20.00, 'stock' => 50, 'description' => 'Cerf-volant facile à voler pour les sorties en plein air.'],
        
            // Jeux de société et famille
            ['category_id' => $catIds['board-games'], 'name' => 'Monopoly Junior', 'slug' => 'monopoly-junior', 'price' => 35.00, 'stock' => 60, 'description' => 'Version simplifiée du Monopoly pour enfants.'],
            ['category_id' => $catIds['board-games'], 'name' => 'Dobble', 'slug' => 'dobble', 'price' => 18.00, 'stock' => 100, 'description' => 'Jeu de cartes pour développer l’observation et la rapidité.'],
        
            // Jouets d'éveil et 1er âge
            ['category_id' => $catIds['baby-toys'], 'name' => 'Hochet Bébé', 'slug' => 'hochet-bebe', 'price' => 10.00, 'stock' => 120, 'description' => 'Hochet coloré pour stimuler les sens du bébé.'],
            ['category_id' => $catIds['baby-toys'], 'name' => 'Tapis d’Éveil', 'slug' => 'tapis-eveil', 'price' => 40.00, 'stock' => 50, 'description' => 'Tapis interactif pour le développement moteur et visuel.'],
        
            // Déguisements et costumes
            ['category_id' => $catIds['costumes'], 'name' => 'Déguisement Pirate', 'slug' => 'deguisement-pirate', 'price' => 25.00, 'stock' => 30, 'description' => 'Costume complet de pirate pour jouer et s’amuser.'],
            ['category_id' => $catIds['costumes'], 'name' => 'Déguisement Princesse', 'slug' => 'deguisement-princesse', 'price' => 30.00, 'stock' => 40, 'description' => 'Robe et accessoires pour un jeu de rôle féérique.'],
        
            // Jeux éducatifs et scientifiques
            ['category_id' => $catIds['educational'], 'name' => 'Kit Science pour Enfants', 'slug' => 'kit-science-enfants', 'price' => 35.00, 'stock' => 70, 'description' => 'Expériences simples pour découvrir la science.'],
            ['category_id' => $catIds['educational'], 'name' => 'Puzzle Alphabet', 'slug' => 'puzzle-alphabet', 'price' => 15.00, 'stock' => 80, 'description' => 'Puzzle éducatif pour apprendre les lettres en s’amusant.'],
        ];
        

        foreach ($products as $product) {
            $productId = DB::table('products')->insertGetId(array_merge($product, [
                'status' => 'active',
                'created_at' => now(), 'updated_at' => now()
            ]));

            // Add demo image
            $toyImages = [
                'https://images.unsplash.com/photo-1558060370-d644479cb6f7?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1531323380165-66811795e0df?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1585155770447-2f66e2a397b5?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1566576721346-d4a3b4eaad5b?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1515488764276-beab7607c1e6?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1545558014-8692077e9b5c?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1599623560574-39d485900c95?q=80&w=800&auto=format&fit=crop',
            ];

            DB::table('product_images')->insert([
                'product_id' => $productId,
                'image' => $toyImages[array_rand($toyImages)],
                'is_primary' => true,
                'created_at' => now(), 'updated_at' => now()
            ]);
        }
    }
}
