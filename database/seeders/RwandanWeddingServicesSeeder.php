<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RwandanWeddingServicesSeeder extends Seeder
{
    public function run(): void
    {
        // Create vendors (approved) for various Rwandan wedding categories
        $vendorData = [
            [
                'name'  => 'Kigali Grand Events',
                'email' => 'kigali.grand@intelliwed.rw',
                'desc'  => 'Premier event venue in the heart of Kigali',
            ],
            [
                'name'  => 'Ubumuntu Catering Services',
                'email' => 'ubumuntu.catering@intelliwed.rw',
                'desc'  => 'Authentic Rwandan and continental cuisine specialists',
            ],
            [
                'name'  => 'Inzozi Photography',
                'email' => 'inzozi.photo@intelliwed.rw',
                'desc'  => 'Capturing your wedding dreams across Rwanda',
            ],
            [
                'name'  => 'Urugo Decor & Flowers',
                'email' => 'urugo.decor@intelliwed.rw',
                'desc'  => 'Traditional and modern Rwandan wedding decorations',
            ],
            [
                'name'  => 'Imvutano Bridal House',
                'email' => 'imvutano.bridal@intelliwed.rw',
                'desc'  => 'Rwandan bridal attire, umushanana and beauty services',
            ],
            [
                'name'  => 'Inanga Sounds & Entertainment',
                'email' => 'inanga.sounds@intelliwed.rw',
                'desc'  => 'Traditional and contemporary Rwandan wedding music',
            ],
            [
                'name'  => 'Agasaro Invitations & Print',
                'email' => 'agasaro.print@intelliwed.rw',
                'desc'  => 'Custom wedding invitations and stationery',
            ],
            [
                'name'  => 'Kigali Luxury Transport',
                'email' => 'kigali.transport@intelliwed.rw',
                'desc'  => 'Luxury bridal cars and guest transport across Rwanda',
            ],
            [
                'name'  => 'Ubutumwa Ceremony Planners',
                'email' => 'ubutumwa.ceremony@intelliwed.rw',
                'desc'  => 'Gusaba, civil & church ceremony coordination',
            ],
            [
                'name'  => 'Iminsi Myiza Event Solutions',
                'email' => 'iminsi.myiza@intelliwed.rw',
                'desc'  => 'Full-service Rwandan wedding planning and coordination',
            ],
        ];

        $vendors = [];
        foreach ($vendorData as $data) {
            // Skip if user already exists
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                    'role'     => 'vendor',
                ]
            );

            $vendor = Vendor::firstOrCreate(
                ['user_id' => $user->id],
                ['status' => 'approved']
            );

            // Ensure vendor is approved
            $vendor->update(['status' => 'approved']);
            $vendors[$data['name']] = $vendor;
        }

        // ─── VENUES ──────────────────────────────────────────────────────────
        $v = $vendors['Kigali Grand Events'];
        $services = [
            [
                'vendor_id'    => $v->id,
                'title'        => 'Kigali Convention Centre – Grand Hall',
                'category'     => 'venue',
                'description'  => 'Rwanda\'s most iconic venue, the KCC Grand Hall hosts up to 2,000 guests in a state-of-the-art environment with panoramic views of Kigali. Includes full AV setup, air-conditioning, VIP lounge, and a dedicated bridal suite. Perfect for grand Rwandan wedding receptions with both traditional and modern décor.',
                'price'        => 3500000,
                'location'     => 'KG 2 Roundabout, Kigali',
                'contact_info' => '+250 788 100 200',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $v->id,
                'title'        => 'Serena Hotel Gorilla Room – Wedding Reception',
                'category'     => 'venue',
                'description'  => 'Elegant ballroom at Hotel des Mille Collines, accommodating up to 500 guests. Features crystal chandeliers, garden terrace access, dedicated catering team, and professional event coordination. Ideal for sophisticated Kigali weddings with a classic touch.',
                'price'        => 2800000,
                'location'     => 'Boulevard de la Révolution, Kigali',
                'contact_info' => '+250 788 200 300',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $v->id,
                'title'        => 'Umusambi Village – Outdoor Cultural Ceremony',
                'category'     => 'venue',
                'description'  => 'A stunning outdoor venue in Kigali\'s green hills, designed for traditional Rwandan Gusaba and Kwanjula ceremonies. Features traditional Intore dance performance area, traditional grass huts (inka-huts), and capacity for 300 guests. Truly authentic Rwandan wedding experience surrounded by nature.',
                'price'        => 1200000,
                'location'     => 'Nyarutarama, Kigali',
                'contact_info' => '+250 788 300 400',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $v->id,
                'title'        => 'Lake Muhazi Garden Resort – Lakeside Wedding',
                'category'     => 'venue',
                'description'  => 'Breathtaking lakeside venue on the shores of Lake Muhazi, Eastern Province. Perfect for intimate weddings of up to 150 guests with a backdrop of Rwanda\'s beautiful lake landscape. Includes boat rides for the bridal party, open-air dance floor, and full catering facilities.',
                'price'        => 1800000,
                'location'     => 'Lake Muhazi, Eastern Province',
                'contact_info' => '+250 788 400 500',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $v->id,
                'title'        => 'Musanze Cultural Centre – Northern Province Wedding',
                'category'     => 'venue',
                'description'  => 'Nestled at the foot of the Virunga volcanoes, this stunning cultural venue blends traditional Rwandan architecture with modern facilities. Capacity for 400 guests. Experience your wedding day against the magnificent backdrop of Rwanda\'s famous volcanoes.',
                'price'        => 1500000,
                'location'     => 'Musanze, Northern Province',
                'contact_info' => '+250 788 500 600',
                'status'       => 'active',
            ],

            // ─── CATERING ────────────────────────────────────────────────────
            [
                'vendor_id'    => $vendors['Ubumuntu Catering Services']->id,
                'title'        => 'Full Rwandan Traditional Wedding Feast (300 guests)',
                'category'     => 'catering',
                'description'  => 'Authentic Rwandan wedding feast featuring Isombe (cassava leaves), Ibirayi (potatoes), Igitoki (plantain), Umutsima (maize & cassava porridge), roasted goat (Inyama y\'ihene), grilled tilapia (Inzovu z\'ifi), Brochettes, and traditional Ikigage beer. Served buffet style with professional waitstaff. Price covers 300 guests.',
                'price'        => 2400000,
                'location'     => 'Kigali (delivery available nationwide)',
                'contact_info' => '+250 788 600 700',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Ubumuntu Catering Services']->id,
                'title'        => 'Continental & Rwandan Fusion Menu (200 guests)',
                'category'     => 'catering',
                'description'  => 'A sophisticated fusion of Rwandan traditional dishes and continental cuisine. Includes 3-course sit-down dinner with amuse-bouche, starter, main course (choice of Inyama y\'inka, chicken, fish), and desserts including Isambaza fritters and fresh tropical fruit. Professional service, linen, crockery and cutlery included.',
                'price'        => 1800000,
                'location'     => 'Kigali and surrounding areas',
                'contact_info' => '+250 788 600 700',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Ubumuntu Catering Services']->id,
                'title'        => 'Gusaba Ceremony Catering Package (100 guests)',
                'category'     => 'catering',
                'description'  => 'Specially curated catering for the traditional Gusaba (introduction ceremony). Includes traditional Rwandan drinks (Ikigage, Urwagwa), roasted meats, Ibiharage, Imineke, Ibirayi, and assorted Rwandan snacks. Served in traditional calabashes and clay pots for authentic presentation.',
                'price'        => 850000,
                'location'     => 'Kigali and all provinces',
                'contact_info' => '+250 788 600 701',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Ubumuntu Catering Services']->id,
                'title'        => 'Wedding Cake – Umutsima Traditional 5-Tier',
                'category'     => 'catering',
                'description'  => 'Stunning 5-tier wedding cake incorporating Rwandan flavours: banana sponge, passion fruit cream, vanilla, and chocolate tiers decorated with Imigongo art-inspired patterns in black, white and red. Includes traditional wedding cake cutting ceremony coordination.',
                'price'        => 350000,
                'location'     => 'Kigali (nationwide delivery available)',
                'contact_info' => '+250 788 600 702',
                'status'       => 'active',
            ],

            // ─── PHOTOGRAPHY ─────────────────────────────────────────────────
            [
                'vendor_id'    => $vendors['Inzozi Photography']->id,
                'title'        => 'Full Day Wedding Photography – Premium Package',
                'category'     => 'photography',
                'description'  => 'Complete wedding day photography coverage from Gusaba/Kwanjula preparations to reception. Includes 2 professional photographers, drone aerial shots, 500+ edited high-resolution photos, online gallery, 40-page premium photo album, and 12-month digital archive. Same-day sneak peek of 20 photos.',
                'price'        => 1200000,
                'location'     => 'Nationwide Rwanda',
                'contact_info' => '+250 788 700 800',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Inzozi Photography']->id,
                'title'        => 'Wedding Videography – Cinematic Film Package',
                'category'     => 'photography',
                'description'  => 'Professional 4K cinematic wedding film capturing every emotion of your big day. Includes 3-5 minute highlight reel, full ceremony video, speech recordings, drone footage, and same-day edit for reception. Delivered on USB and streaming link. Perfect for sharing with family across Rwanda and abroad.',
                'price'        => 900000,
                'location'     => 'Nationwide Rwanda',
                'contact_info' => '+250 788 700 801',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Inzozi Photography']->id,
                'title'        => 'Gusaba Traditional Ceremony Photography',
                'category'     => 'photography',
                'description'  => 'Dedicated photography for the traditional Rwandan Gusaba ceremony. Documents the dowry negotiations, traditional dances, family introductions, and cultural rituals with sensitivity and artistry. Includes 200 edited photos delivered within 48 hours, perfect for preserving this important cultural milestone.',
                'price'        => 450000,
                'location'     => 'Kigali and all provinces',
                'contact_info' => '+250 788 700 802',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Inzozi Photography']->id,
                'title'        => 'Pre-Wedding Shoot – Rwandan Landscapes',
                'category'     => 'photography',
                'description'  => 'Romantic pre-wedding photoshoot at iconic Rwandan locations: Nyungwe Forest, Lake Kivu, Volcanoes National Park, or the rolling hills of Kigali. Full-day session with wardrobe changes (including Umushanana), 150 edited photos, and styled props. A lasting memory of Rwanda\'s beauty.',
                'price'        => 380000,
                'location'     => 'Nationwide (location of your choice)',
                'contact_info' => '+250 788 700 803',
                'status'       => 'active',
            ],

            // ─── DECORATION ──────────────────────────────────────────────────
            [
                'vendor_id'    => $vendors['Urugo Decor & Flowers']->id,
                'title'        => 'Traditional Rwandan Wedding Décor Package',
                'category'     => 'decor',
                'description'  => 'Authentic Rwandan décor using Agaseke baskets, Imigongo art panels, traditional cow horns, woven mats, and natural flowers. Features a stunning sweetheart table with Inzuki (honeybee) theme, traditional arch decorated with banana leaves and local flowers, table centerpieces using Agaseke, and cultural fabric draping throughout the venue.',
                'price'        => 800000,
                'location'     => 'Kigali and surrounding areas',
                'contact_info' => '+250 788 800 900',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Urugo Decor & Flowers']->id,
                'title'        => 'Luxury Floral & Modern Décor Package',
                'category'     => 'decor',
                'description'  => 'Elegant modern wedding décor blending European floral design with Rwandan elements. Includes grand floral arch (roses, proteas, eucalyptus), ceiling flower installations, 20 table centerpieces, floral crown for the bride, bouquet and boutonnieres, aisle petal arrangement, and full venue transformation. Color scheme of your choice.',
                'price'        => 1400000,
                'location'     => 'Kigali',
                'contact_info' => '+250 788 800 901',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Urugo Decor & Flowers']->id,
                'title'        => 'Gusaba Ceremony Décor – Cultural Setup',
                'category'     => 'decor',
                'description'  => 'Complete decoration for the traditional Gusaba ceremony. Includes Ubutegetsi (ceremonial throne) setup, Agaseke basket displays, traditional fabric (Indwi), cow skin rugs, floral garlands, and ambient lighting. Sets the perfect scene for this important cultural ceremony with colours representing Rwandan heritage.',
                'price'        => 550000,
                'location'     => 'Nationwide Rwanda',
                'contact_info' => '+250 788 800 902',
                'status'       => 'active',
            ],

            // ─── ATTIRE & BEAUTY ─────────────────────────────────────────────
            [
                'vendor_id'    => $vendors['Imvutano Bridal House']->id,
                'title'        => 'Umushanana – Premium Bridal Attire Package',
                'category'     => 'attire',
                'description'  => 'Complete bridal Umushanana (traditional Rwandan dress) crafted from premium silk and satin fabric. Includes custom-fitted umushanana in the colour of your choice, matching headpiece, traditional beaded jewellery (necklace, earrings, bracelet), and hand-decorated Agaseke clutch bag. Also includes groom\'s traditional Rwandan outfit.',
                'price'        => 750000,
                'location'     => 'Kigali City',
                'contact_info' => '+250 788 900 001',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Imvutano Bridal House']->id,
                'title'        => 'Bridal Makeup & Hair – Traditional & Modern',
                'category'     => 'attire',
                'description'  => 'Full bridal beauty service by certified makeup artists specialising in Rwandan bridal looks. Package includes: trial makeup session, wedding day makeup (traditional or modern), hair styling (natural, weaves, or traditional styles), bridesmaids makeup (up to 4), touch-up kit, and on-site attendance during ceremony.',
                'price'        => 320000,
                'location'     => 'Kigali (home visits available)',
                'contact_info' => '+250 788 900 002',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Imvutano Bridal House']->id,
                'title'        => 'Western Wedding Gown – Design & Tailoring',
                'category'     => 'attire',
                'description'  => 'Custom-designed and tailored western wedding gown made in Rwanda. Choose from A-line, ballgown, mermaid or sheath silhouettes. Made with imported lace, tulle and satin with Rwandan Kitenge accent details. Includes 3 fittings, alterations, and dress preservation after the wedding.',
                'price'        => 980000,
                'location'     => 'Kigali',
                'contact_info' => '+250 788 900 003',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Imvutano Bridal House']->id,
                'title'        => 'Bridal Party Attire – Bridesmaids Umushanana (6 persons)',
                'category'     => 'attire',
                'description'  => 'Coordinated Umushanana for the entire bridal party. Package covers 6 bridesmaids with matching fabric and custom tailoring. Includes fitting sessions, accessories guidance, and delivery. Fabric choices range from solid colours to patterned Kitenge and Ankara prints popular at Rwandan weddings.',
                'price'        => 600000,
                'location'     => 'Kigali',
                'contact_info' => '+250 788 900 004',
                'status'       => 'active',
            ],

            // ─── MUSIC & ENTERTAINMENT ───────────────────────────────────────
            [
                'vendor_id'    => $vendors['Inanga Sounds & Entertainment']->id,
                'title'        => 'Intore Cultural Dance Troupe',
                'category'     => 'music',
                'description'  => 'Rwanda\'s iconic Intore warriors and dancers performing at your wedding. The troupe of 12 performers in full traditional costume delivers a 45-minute show including the Umushagiriro (female dance), Intore warrior dance, and Igisoro board game display. A truly unforgettable Rwandan cultural experience for you and your guests.',
                'price'        => 650000,
                'location'     => 'Nationwide Rwanda',
                'contact_info' => '+250 788 001 002',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Inanga Sounds & Entertainment']->id,
                'title'        => 'Live Inanga & Traditional Music Ensemble',
                'category'     => 'music',
                'description'  => 'Soulful live performance by Rwanda\'s master Inanga (traditional harp) players accompanied by Ingoma drums and Iningiri fiddle. Perfect for ceremony background music, Gusaba ambiance, and dinner reception atmosphere. 4-hour package with 3 musicians, customised song selection including popular Rwandan wedding songs.',
                'price'        => 420000,
                'location'     => 'Kigali and major towns',
                'contact_info' => '+250 788 001 003',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Inanga Sounds & Entertainment']->id,
                'title'        => 'Contemporary DJ & Sound System Package',
                'category'     => 'music',
                'description'  => 'Professional DJ service for wedding receptions. Includes top Rwandan artists (Meddy, Knowless, Kivumbi King), Afrobeats, gospel, and international hits. Full professional sound system (10,000W), intelligent lighting, fog machine, and wireless microphones. 8-hour package with Master of Ceremony service available.',
                'price'        => 500000,
                'location'     => 'Kigali and surrounding areas',
                'contact_info' => '+250 788 001 004',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Inanga Sounds & Entertainment']->id,
                'title'        => 'Ingoma (Drum) Ceremony Welcome',
                'category'     => 'music',
                'description'  => 'Traditional Rwandan Ingoma royal drum performance to welcome the bride and groom at your ceremony. 8 royal drummers in full Urukwavu (traditional costume) perform a powerful 20-minute welcome ceremony. This traditional honour was historically reserved for royalty and now graces the most memorable Rwandan weddings.',
                'price'        => 280000,
                'location'     => 'Nationwide Rwanda',
                'contact_info' => '+250 788 001 005',
                'status'       => 'active',
            ],

            // ─── INVITATIONS ────────────────────────────────────────────────
            [
                'vendor_id'    => $vendors['Agasaro Invitations & Print']->id,
                'title'        => 'Agaseke-Inspired Wedding Invitation Suite (200 pcs)',
                'category'     => 'invitations',
                'description'  => 'Beautifully crafted wedding invitation suite inspired by the traditional Rwandan Agaseke (woven basket) geometric patterns. Includes main invitation card, RSVP card, details card, and custom envelope with wax seal. Printed on premium 400gsm textured paper in your wedding colours. 200 sets. Available in Kinyarwanda, French, and English.',
                'price'        => 280000,
                'location'     => 'Kigali (nationwide delivery)',
                'contact_info' => '+250 788 100 002',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Agasaro Invitations & Print']->id,
                'title'        => 'Digital Wedding Invitation & Wedding Website',
                'category'     => 'invitations',
                'description'  => 'Modern digital wedding invitation with animated Rwandan-themed design plus a personalised wedding website. Features RSVP management, event schedule, photo gallery, accommodation suggestions, and Google Maps integration. WhatsApp-ready format for easy sharing. Includes unlimited edits and 12-month hosting.',
                'price'        => 120000,
                'location'     => 'Online – nationwide',
                'contact_info' => '+250 788 100 003',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Agasaro Invitations & Print']->id,
                'title'        => 'Wedding Programme, Menu & Signage Package',
                'category'     => 'invitations',
                'description'  => 'Complete printed stationery for your wedding day: 200 ceremony programmes, 20 table menu cards, welcome signage, table numbers, seating chart, place cards, and thank-you cards. Designed with Rwandan Imigongo art motifs and printed on premium stock. Bilingual (Kinyarwanda/English) options available.',
                'price'        => 180000,
                'location'     => 'Kigali',
                'contact_info' => '+250 788 100 004',
                'status'       => 'active',
            ],

            // ─── TRANSPORT ───────────────────────────────────────────────────
            [
                'vendor_id'    => $vendors['Kigali Luxury Transport']->id,
                'title'        => 'Bridal Car – Luxury Mercedes S-Class',
                'category'     => 'transport',
                'description'  => 'Arrive in ultimate style in a chauffeured Mercedes-Benz S-Class decorated with fresh white roses and ribbon. Includes professional uniformed chauffeur, champagne on arrival, red carpet service, and coordination with wedding timeline. 6-hour hire covering ceremony and reception transfers across Kigali.',
                'price'        => 380000,
                'location'     => 'Kigali',
                'contact_info' => '+250 788 200 002',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Kigali Luxury Transport']->id,
                'title'        => 'Guest Shuttle Fleet – 5 Coaster Buses',
                'category'     => 'transport',
                'description'  => 'Comfortable and reliable guest transport service using a fleet of 5 modern Toyota Coaster buses (30 seats each). Covers pickup from Kigali hotels, ceremony venue, reception venue, and return drops. Includes professional drivers, fuel, and an on-board coordinator. Ideal for large weddings with out-of-town guests.',
                'price'        => 600000,
                'location'     => 'Kigali and surrounding areas',
                'contact_info' => '+250 788 200 003',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Kigali Luxury Transport']->id,
                'title'        => 'Vintage Classic Car – 1960s Peugeot Bridal Entry',
                'category'     => 'transport',
                'description'  => 'Make a statement with a beautifully restored 1960s Peugeot 404 in pristine white, reminiscent of Rwanda\'s colonial elegance. Decorated with traditional Agaseke weave patterns and fresh flowers. Includes chauffeur in traditional dress, photography stops, and full-day hire. A unique piece of Rwandan history for your special day.',
                'price'        => 250000,
                'location'     => 'Kigali',
                'contact_info' => '+250 788 200 004',
                'status'       => 'active',
            ],

            // ─── CEREMONY ────────────────────────────────────────────────────
            [
                'vendor_id'    => $vendors['Ubutumwa Ceremony Planners']->id,
                'title'        => 'Gusaba – Full Traditional Introduction Ceremony Planning',
                'category'     => 'ceremony',
                'description'  => 'Complete coordination of the traditional Rwandan Gusaba (introduction/engagement ceremony). Services include: family liaison and protocol guidance, Intebe (gift list) preparation, Inyambo cow arrangement and blessing, venue setup with traditional décor, cultural emcee fluent in Kinyarwanda, Ingoma drummers, and full event timeline management. Honouring every Rwandan custom.',
                'price'        => 950000,
                'location'     => 'Nationwide Rwanda',
                'contact_info' => '+250 788 300 002',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Ubutumwa Ceremony Planners']->id,
                'title'        => 'Civil Wedding Ceremony – Kigali City Hall Package',
                'category'     => 'ceremony',
                'description'  => 'Comprehensive support for civil wedding registration and ceremony at Kigali City Hall or any district office in Rwanda. Includes document preparation (birth certificates, affidavits, marriage notice), scheduling with the registrar, ceremony decoration, flowers, and photography coordination. Legal name change assistance included.',
                'price'        => 350000,
                'location'     => 'Kigali (all districts available)',
                'contact_info' => '+250 788 300 003',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Ubutumwa Ceremony Planners']->id,
                'title'        => 'Church Wedding Ceremony Coordination',
                'category'     => 'ceremony',
                'description'  => 'Full coordination for church wedding ceremonies across Rwanda\'s major denominations (Catholic, Protestant, Seventh-Day Adventist, Anglican). Includes liaison with clergy, floral arrangement for the church, rehearsal coordination, wedding programme printing, aisle décor, and day-of coordination team. Available nationwide.',
                'price'        => 480000,
                'location'     => 'Nationwide Rwanda',
                'contact_info' => '+250 788 300 004',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Ubutumwa Ceremony Planners']->id,
                'title'        => 'Kwanjula – Traditional Handover Ceremony',
                'category'     => 'ceremony',
                'description'  => 'Expert planning of the Kwanjula (bride handover) ceremony, the final step in the Rwandan traditional marriage process. Includes cultural protocol advisory, Inyambo (long-horned cattle) arrangements, traditional spokesperson services, gifts (Ingobyi) organisation, family meetings facilitation, and full ceremony décor with traditional artifacts.',
                'price'        => 750000,
                'location'     => 'Nationwide Rwanda',
                'contact_info' => '+250 788 300 005',
                'status'       => 'active',
            ],

            // ─── OTHER / FULL PLANNING ────────────────────────────────────────
            [
                'vendor_id'    => $vendors['Iminsi Myiza Event Solutions']->id,
                'title'        => 'Full Wedding Planning Package – Ubunyamukuru',
                'category'     => 'other',
                'description'  => 'End-to-end wedding planning service covering the entire Rwandan wedding journey from Gusaba to reception. Dedicated wedding planner, vendor coordination, budget management, timeline creation, venue sourcing, décor oversight, catering liaison, rehearsal dinner planning, and day-of coordination team of 5. Rwanda\'s most comprehensive planning service.',
                'price'        => 2500000,
                'location'     => 'Nationwide Rwanda',
                'contact_info' => '+250 788 400 002',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Iminsi Myiza Event Solutions']->id,
                'title'        => 'Honeymoon Planning – Rwanda & East Africa',
                'category'     => 'other',
                'description'  => 'Tailored honeymoon planning across Rwanda and East Africa. Packages include gorilla trekking in Volcanoes National Park, Lake Kivu sunset cruise, Akagera wildlife safari, Nyungwe canopy walk, and Zanzibar beach extension. Includes accommodation at top lodges, transport, and a dedicated travel concierge.',
                'price'        => 3200000,
                'location'     => 'Nationwide + East Africa',
                'contact_info' => '+250 788 400 003',
                'status'       => 'active',
            ],
            [
                'vendor_id'    => $vendors['Iminsi Myiza Event Solutions']->id,
                'title'        => 'Wedding Anniversary & Vow Renewal Package',
                'category'     => 'other',
                'description'  => 'Celebrate your love with a Rwandan-style vow renewal ceremony. Package includes intimate ceremony planning (up to 50 guests), traditional décor, Umushanana renewal fitting, professional photography, catering, and a surprise element inspired by your original wedding. Includes Ubutumwa (messenger) to deliver invitations to family.',
                'price'        => 1200000,
                'location'     => 'Kigali and Lake Kivu',
                'contact_info' => '+250 788 400 004',
                'status'       => 'active',
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }

        $this->command->info('✅ ' . count($services) . ' Rwandan wedding services seeded successfully!');
        $this->command->info('✅ ' . count($vendorData) . ' vendors created/approved.');
    }
}
