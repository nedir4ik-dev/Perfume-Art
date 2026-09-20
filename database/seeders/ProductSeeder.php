<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use \Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brand = Brand::first();
        $category = Category::first();

        $perfumes = [
            ['name' => 'Bleu de Chanel', 'price' => 120, 'gender' => 'Men', 'ml' => '100', 'image' => 'bleu-de-chanel.jpg', 'stock' => '12'],
            ['name' => 'Dior Sauvage', 'price' => 39, 'gender' => 'Men', 'ml' => '100', 'image' => 'dior-sauvage.jpg', 'stock' => '10'],
            ['name' => 'Creed Aventus', 'price' => 70, 'gender' => 'Men', 'ml' => '75', 'image' => 'creed-aventus.jpg', 'stock' => '17'],
            ['name' => 'Chanel No 5', 'price' => 55, 'gender' => 'Women', 'ml' => '50', 'image' => 'chanel-no-5.jpg', 'stock' => '5'],
            ['name' => 'Coco Mademoiselle', 'price' => 270, 'gender' => 'Women', 'ml' => '50', 'image' => 'coco-mademoiselle.jpg', 'stock' => '12'],
            ['name' => 'Baccarat Rouge 540', 'price' => 40, 'gender' => 'Unisex', 'ml' => '70', 'image' => 'baccarat-rouge-540.jpg', 'stock' => '25'],
            ['name' => 'Versace Eros', 'price' => 65, 'gender' => 'Men', 'ml' => '100', 'image' => 'versace-eros.jpg', 'stock' => '46'],
            ['name' => 'Stonger With You Intensely', 'price' => 69, 'gender' => 'Men', 'ml' => '100', 'image' => 'stronger-with-you.jpg', 'stock' => '1'],
            ['name' => 'SansiroTango', 'price' => 30, 'gender' => 'Men', 'ml' => '75', 'image' => 'sansiro-tango.jpg', 'stock' => '43'],
            ['name' => 'Armaf Club de Nuit', 'price' => 65, 'gender' => 'Women', 'ml' => '250', 'image' => 'club-de-nuit-women.jpg', 'stock' => '77'],
            ['name' => 'Armaf Club de Nuit Precieux', 'price' => 70, 'gender' => 'Men', 'ml' => '55', 'image' => 'club-de-nuit-precieux.jpg', 'stock' => '30'],
            ['name' => 'Lattafa Perfumes Hayaati', 'price' => 32, 'gender' => 'Men', 'ml' => '250', 'image' => 'lattafa-hayaati.jpg', 'stock' => '100'],
            ['name' => 'Tom Ford Black Lacquer', 'price' => 405, 'gender' => 'Men', 'ml' => '50', 'image' => 'tom-ford-black.jpg', 'stock' => '8'],
            ['name' => 'Louis Vuitton Imagination', 'price' => 530, 'gender' => 'Men', 'ml' => '200', 'image' => 'louis-vuitton-imagination.jpg', 'stock' => '4'],
            ['name' => 'Black Afgano', 'price' => 238, 'gender' => 'Unisex', 'ml' => '50', 'image' => 'black-afgano-unisex.jpg', 'stock' => '15'],
            ['name' => 'Yves Saint Laurent Libre', 'price' => 140, 'gender' => 'Women', 'ml' => '90', 'image' => 'ysl-libre.jpg', 'stock' => '22'],
            ['name' => 'Carolina Herrera Good Girl', 'price' => 124, 'gender' => 'Women', 'ml' => '80', 'image' => 'good-girl.jpg', 'stock' => '18'],
            ['name' => 'Jean Paul Gaultier Le Male', 'price' => 123, 'gender' => 'Men', 'ml' => '125', 'image' => 'jpg-le-male.jpg', 'stock' => '33'],
            ['name' => 'Parfums de Marly Delina', 'price' => 355, 'gender' => 'Women', 'ml' => '75', 'image' => 'pdm-delina.jpg', 'stock' => '6'],
            ['name' => 'Tom Ford Lost Cherry', 'price' => 405, 'gender' => 'Unisex', 'ml' => '50', 'image' => 'tf-lost-cherry.jpg', 'stock' => '9'],
            ['name' => 'Xerjoff Erba Pura', 'price' => 237, 'gender' => 'Unisex', 'ml' => '100', 'image' => 'erba-pura.jpg', 'stock' => '11'],
            ['name' => 'Byredo Gypsy Water', 'price' => 235, 'gender' => 'Unisex', 'ml' => '50', 'image' => 'byredo-gypsy.jpg', 'stock' => '14'],
            ['name' => 'Armaf Club De Nuit Intense', 'price' => 75, 'gender' => 'Men', 'ml' => '200', 'image' => 'armaf-club-de-nuit-intense.jpg', 'stock' => '50'],
            ['name' => 'Armaf Club De Nuit Iconic', 'price' => 75, 'gender' => 'Men', 'ml' => '200', 'image' => 'armaf-club-de-nuit-blue-iconic.jpg', 'stock' => '45'],
            ['name' => 'Mercedes-Benz Le Parfum', 'price' => 50, 'gender' => 'Men', 'ml' => '120', 'image' => 'mercedes-benz-le-parfum.jpg', 'stock' => '20'],
            ['name' => 'Dior Miss-Dior Essence', 'price' => 229, 'gender' => 'Women', 'ml' => '80', 'image' => 'miss-dior-essence.jpg', 'stock' => '13'],
            ['name' => 'Valentino Born In Roma', 'price' => 180, 'gender' => 'Men', 'ml' => '100', 'image' => 'valentino-born-in-roma.jpg', 'stock' => '27'],
            ['name' => 'Valentino Yellow Dreamm', 'price' => 180, 'gender' => 'Women', 'ml' => '100', 'image' => 'valentino-yellow-dream.jpg', 'stock' => '19'],
            ['name' => 'Valentino Intense', 'price' => 160, 'gender' => 'Men', 'ml' => '100', 'image' => 'valentino-intense.jpg', 'stock' => '31'],
            ['name' => 'Valentino Green Stravaganza', 'price' => 145, 'gender' => 'Men', 'ml' => '50', 'image' => 'valentino-green_stravaganza.jpg', 'stock' => '24'],
            ['name' => 'Tom Ford Ombré Leather', 'price' => 100, 'gender' => 'Men', 'ml' => '50', 'image' => 'tom-ford-ombre-leather.jpg', 'stock' => '16'],
            ['name' => 'Yves Saint Laurent Y Edp', 'price' => 165, 'gender' => 'Men', 'ml' => '100', 'image' => 'ysl-y-edp.jpg', 'stock' => '40'],
            ['name' => 'No.2 Men', 'price' => 78, 'gender' => 'Men', 'ml' => '100', 'image' => 'no2-men.jpg', 'stock' => '80'],
            ['name' => 'Dirham Ard-Al Zaafaran', 'price' => 23, 'gender' => 'Men', 'ml' => '100', 'image' => 'dirham-ard-al-zaafaran.jpg', 'stock' => '120'],
            ['name' => 'Dirham Oud Edp', 'price' => 24, 'gender' => 'Men', 'ml' => '100', 'image' => 'dirham-oud-edp.jpg', 'stock' => '95'],
            ['name' => 'Passant Guadrant', 'price' => 228, 'gender' => 'Men', 'ml' => '30', 'image' => 'passant-guardant.jpg', 'stock' => '7'],
            ['name' => 'Paco Rabanne 1 Million', 'price' => 57, 'gender' => 'Men', 'ml' => '100', 'image' => 'one-million.jpg', 'stock' => '65'],
            ['name' => 'Roja Parfums Haute Luxe', 'price' => 3500, 'gender' => 'Men', 'ml' => '100', 'image' => 'roja-parfum.jpg', 'stock' => '2'],
            ['name' => 'Avon Incandessence', 'price' => 25, 'gender' => 'Women', 'ml' => '50', 'image' => 'incandessence-enjoy.jpg', 'stock' => '200'],
            ['name' => 'Fragrance Du Bois Sahraa Oud', 'price' => 1100, 'gender' => 'Men', 'ml' => '100', 'image' => 'fragnance-du-bois-sahraa-oud.jpg', 'stock' => '3'],
            ['name' => 'DKNY Golden Delicious Million Dollar', 'price' => 1000000, 'gender' => 'Women', 'ml' => '50', 'image' => 'dkny.jpg', 'stock' => '1'],
            ['name' => 'Joy by Jean Patou', 'price' => 850, 'gender' => 'Women', 'ml' => '30', 'image' => 'joy-by-jean-patou.jpg', 'stock' => '5'],
            ['name' => 'Baccarat Les Larmes Sacrées de Thèbes', 'price' => 6800, 'gender' => 'Women', 'ml' => '30', 'image' => 'baccarat-les-larmes.jpg', 'stock' => '2'],
            ['name' => 'Le Monde Sur Mesure (Morreale Paris)', 'price' => 180000, 'gender' => 'Unisex', 'ml' => '5000', 'image' => 'moreale-paris.jpg', 'stock' => '1'],
            ['name' => 'Shumukh (The Spirit of Dubai)', 'price' => 129500, 'gender' => 'Unisex', 'ml' => '3000', 'image' => 'Shumukh.jpg', 'stock' => '1'],
            ['name' => 'Clive Christian No. 1 Imperial Majesty', 'price' => 215000, 'gender' => 'Unisex', 'ml' => '500', 'image' => 'imperial-majesty.jpg', 'stock' => '1'],
            ['name' => 'Bvlgari Le Gemme', 'price' => 5000, 'gender' => 'Unisex', 'ml' => '100', 'image' => 'bvlgari-le-gemme.jpg', 'stock' => '3'],
            ['name' => 'Louis Vuitton Ombre Nomade', 'price' => 1400, 'gender' => 'Unisex', 'ml' => '100', 'image' => 'louis-vuitton-ombre-nomade.jpg', 'stock' => '6'],
            ['name' => 'Henry Jacques Bespoke', 'price' => 1320000, 'gender' => 'Unisex', 'ml' => '30', 'image' => 'henry-jacques-bespoke.jpg', 'stock' => '1'],
            ['name' => 'Tom Ford Oud Wood', 'price' => 295, 'gender' => 'Unisex', 'ml' => '50', 'image' => 'tom-ford-bois-marocain.jpg', 'stock' => '21'],
            ['name' => 'By Kilian Back To Back', 'price' => 315, 'gender' => 'Unisex', 'ml' => '50', 'image' => 'kilian-back-to-black-edp.jpg', 'stock' => '14'],
            ['name' => 'Armani Acqua di Gio', 'price' => 110, 'gender' => 'Men', 'ml' => '100', 'image' => 'armani-acqua-di-gio.jpg', 'stock' => '55'],
            ['name' => 'Prada L’Homme', 'price' => 105, 'gender' => 'Men', 'ml' => '100', 'image' => 'prada-lhomme.jpg', 'stock' => '38'],
            ['name' => 'Terre d’Hermès', 'price' => 175, 'gender' => 'Men', 'ml' => '100', 'image' => 'terre-hermes.jpg', 'stock' => '29'],
            ['name' => 'Paco Rabanne Invictus', 'price' => 90, 'gender' => 'Men', 'ml' => '100', 'image' => 'paco-rabanne-invictus.jpg', 'stock' => '47'],
            ['name' => 'Givenchy Gentleman Reserve Privée', 'price' => 118, 'gender' => 'Men', 'ml' => '100', 'image' => 'givenchy-gentleman-reserve.jpg', 'stock' => '12'],
            ['name' => 'Versace Dylan Blue', 'price' => 120, 'gender' => 'Men', 'ml' => '100', 'image' => 'versace-dylan-blue.jpg', 'stock' => '60'],
            ['name' => 'Lalique Encre Noire', 'price' => 45, 'gender' => 'Men', 'ml' => '100', 'image' => 'lalique-encre-noire.jpg', 'stock' => '85'],
            ['name' => 'Azzaro Wanted by Night', 'price' => 90, 'gender' => 'Men', 'ml' => '100', 'image' => 'azzaro-wanted-night.jpg', 'stock' => '34'],
            ['name' => 'Montblanc Explorer Extreme', 'price' => 88, 'gender' => 'Men', 'ml' => '100', 'image' => 'montblanc-explorer-extreme.jpg', 'stock' => '52'],
            ['name' => 'Lancôme La Vie Est Belle', 'price' => 120, 'gender' => 'Women', 'ml' => '75', 'image' => 'la-vie-est-belle.jpg', 'stock' => '41'],
            ['name' => 'Gucci Bloom', 'price' => 135, 'gender' => 'Women', 'ml' => '100', 'image' => 'gucci-bloom.jpg', 'stock' => '26'],
            ['name' => 'Dior J’adore', 'price' => 150, 'gender' => 'Women', 'ml' => '75', 'image' => 'dior-jadore.jpg', 'stock' => '30'],
            ['name' => 'YSL Black Opium', 'price' => 130, 'gender' => 'Women', 'ml' => '90', 'image' => 'ysl-black-opium.jpg', 'stock' => '48'],
            ['name' => 'Versace Bright Crystal', 'price' => 95, 'gender' => 'Women', 'ml' => '90', 'image' => 'versace-bright-crystal.jpg', 'stock' => '72'],
            ['name' => 'Nasomatto Baraonda', 'price' => 185, 'gender' => 'Unisex', 'ml' => '30', 'image' => 'nasomatto-baraonda.jpg', 'stock' => '9'],
            ['name' => 'Initio Oud for Greatness', 'price' => 350, 'gender' => 'Unisex', 'ml' => '90', 'image' => 'initio-oud-greatness.jpg', 'stock' => '5'],
            ['name' => 'Montale Intense Cafe', 'price' => 110, 'gender' => 'Unisex', 'ml' => '100', 'image' => 'intense-cafe-montale.jpg', 'stock' => '23'],
            ['name' => 'Kilian Angels’ Share', 'price' => 230, 'gender' => 'Unisex', 'ml' => '50', 'image' => 'kilian-angels-share.jpg', 'stock' => '11'],
            ['name' => 'Molecule 01', 'price' => 115, 'gender' => 'Unisex', 'ml' => '100', 'image' => 'molecule-01.jpg', 'stock' => '44'],
        ];

        foreach ($perfumes as $key => $p) {
            Product::updateOrCreate(
                ['name' => $p['name']],
                [
                    'brand_id' => $brand->id ?? 1,
                    'category_id' => $category->id ?? 1,
                    'slug' => Str::slug(($key + 1) . '-' . $p['name']),
                    'price' => $p['price'],
                    'stock_quantity' => $p['stock'],
                    'description' => 'Luxury fragrance for an unforgettable presence.',
                    'ml_size' => $p['ml'],
                    'gender' => $p['gender'],
                    'image' => $p['image'] ?? 'default.jpg',
                ]
            );
        }
    }
}
