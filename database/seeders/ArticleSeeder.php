<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@faistroquer.fr',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);
        }

        $articles = [
            [
                'title' => 'Comment bien réussir son premier troc',
                'excerpt' => 'Découvrez nos conseils pour réussir votre première expérience de troc sur notre plateforme.',
                'content' => '
                    <h2>Préparez-vous bien</h2>
                    <p>Avant de vous lancer dans votre premier troc, prenez le temps de bien préparer votre annonce. Photographiez l\'objet sous plusieurs angles, décrivez-le précisément et soyez honnête sur son état.</p>
                    
                    <h2>Communiquez clairement</h2>
                    <p>La communication est la clé d\'un troc réussi. Soyez clair sur ce que vous proposez et ce que vous recherchez en échange.</p>
                    
                    <h2>Sécurisez l\'échange</h2>
                    <p>Choisissez un lieu public pour l\'échange et prenez le temps de bien vérifier les objets avant de finaliser le troc.</p>',
                'category' => 'Conseils',
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Les avantages du troc pour l\'environnement',
                'excerpt' => 'Le troc est une solution écologique pour donner une seconde vie à vos objets.',
                'content' => '
                    <h2>Réduire les déchets</h2>
                    <p>En troquant vos objets au lieu de les jeter, vous contribuez directement à la réduction des déchets et à la préservation de l\'environnement.</p>
                    
                    <h2>Limiter la surconsommation</h2>
                    <p>Le troc encourage une consommation plus responsable en donnant une seconde vie aux objets déjà existants.</p>
                    
                    <h2>Impact carbone</h2>
                    <p>En favorisant les échanges locaux, le troc permet de réduire l\'empreinte carbone liée aux transports et à la production de nouveaux biens.</p>',
                'category' => 'Environnement',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Top 10 des objets les plus troqués',
                'excerpt' => 'Découvrez les objets qui ont le plus de succès sur notre plateforme.',
                'content' => '
                    <h2>1. Les livres</h2>
                    <p>Les livres sont les objets les plus échangés sur notre plateforme. Leur facilité de transport et leur valeur culturelle en font des candidats parfaits pour le troc.</p>
                    
                    <h2>2. Les vêtements</h2>
                    <p>La mode évolue rapidement, et le troc de vêtements permet de renouveler sa garde-robe de manière économique et écologique.</p>
                    
                    <h2>3. Les jeux vidéo</h2>
                    <p>Les jeux vidéo sont très populaires dans le troc, permettant aux joueurs de découvrir de nouveaux titres sans se ruiner.</p>',
                'category' => 'Tendances',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Le troc de services : une tendance en hausse',
                'excerpt' => 'De plus en plus d\'utilisateurs échangent des services sur notre plateforme.',
                'content' => '
                    <h2>Un nouveau mode d\'échange</h2>
                    <p>Le troc de services permet d\'échanger des compétences et du temps, créant ainsi une économie collaborative basée sur l\'entraide.</p>
                    
                    <h2>Les services les plus demandés</h2>
                    <p>Cours particuliers, jardinage, bricolage... Découvrez les services les plus recherchés sur notre plateforme.</p>
                    
                    <h2>Comment bien évaluer un service</h2>
                    <p>Apprenez à estimer la valeur d\'un service pour proposer des échanges équitables.</p>',
                'category' => 'Services',
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Sécuriser ses échanges sur FAISTROQUER',
                'excerpt' => 'Guide complet pour des échanges en toute sécurité.',
                'content' => '
                    <h2>Vérifier les profils</h2>
                    <p>Prenez le temps de consulter les avis et l\'historique des utilisateurs avant de procéder à un échange.</p>
                    
                    <h2>Lieux d\'échange sécurisés</h2>
                    <p>Privilégiez les lieux publics et fréquentés pour vos échanges en personne.</p>
                    
                    <h2>Documentation des échanges</h2>
                    <p>Photographiez les objets et gardez une trace écrite des accords passés.</p>',
                'category' => 'Sécurité',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Les événements de troc près de chez vous',
                'excerpt' => 'Participez aux rencontres de troqueurs organisées dans votre région.',
                'content' => '
                    <h2>Rencontres mensuelles</h2>
                    <p>Chaque mois, des événements sont organisés pour permettre aux membres de se rencontrer et d\'échanger en personne.</p>
                    
                    <h2>Foires au troc</h2>
                    <p>Les grandes foires au troc sont l\'occasion de découvrir une multitude d\'objets et de rencontrer d\'autres passionnés.</p>
                    
                    <h2>Ateliers thématiques</h2>
                    <p>Participez à nos ateliers pour apprendre à mieux valoriser vos objets et services.</p>',
                'category' => 'Événements',
                'is_published' => true,
                'published_at' => now()->subDays(6),
            ],
        ];

        foreach ($articles as $article) {
            Article::create(array_merge($article, [
                'user_id' => $admin->id,
                'slug' => Str::slug($article['title']),
            ]));
        }
    }
} 