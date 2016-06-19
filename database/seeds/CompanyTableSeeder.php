<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Company')->insert([
            'name' => 'Company not listed',
        ]);

        /***********
         ** SPAIN **
         ***********/

        DB::table('Company')->insert([
            'name' => 'Museu del Ferrocarril de Catalunya',
            'country_id' => 724,
            'zip' => '08800',
            'address' => 'Plaza de Eduard Maristany, s/n',
            'city' => 'Vilanova i la Geltrú',
            'email' => 'comunicacio@museudelferrocarril.org',
            'website' => 'http://museudelferrocarril.org/',
            'phonenumber' => '+34 93 815 84 91',
            'Twitter' => 'https://twitter.com/#!/mferrocarrilcat',
            'Facebook' => 'http://www.facebook.com/museudelferrocarril',
            'LinkedIn' => 'http://www.linkedin.com/company/museu-del-ferrocarril-de-catalunya',
            'instagram' => 'http://iconosquare.com/mferrocarrilcat',
            'youtube' => 'http://www.youtube.com/museuferrocarril',
            'flickr' => 'http://www.flickr.com/photos/62688521@N02/sets/',
            'pinterest' => 'http://www.pinterest.com/mferrocarrilcat',
        ]);

        DB::table('Company')->insert([
            'name' => 'Museo del Ferrocarril de Asturias',
            'country_id' => 724,
            'city' => 'Gijón',
            'zip' => '33212',
            'email' => 'museoferrocarril@gijon.es',
            'address' => 'Plaza de la estación del Norte s/b',
            'website' => 'http://museos.gijon.es',
            'phonenumber' => '+34 985 181 777',
        ]);

        DB::table('Company')->insert([
            'name' => 'Museo del Ferrocarril de Galícia',
            'country_id' => 724,
            'city' => 'Monforte de Lemos (Lugo)',
            'zip' => '27400',
            'email' => 'direccion@muferga.es',
            'address' => 'C/ Prolongación Padre Feijoo, s/n',
            'website' => 'http://www.muferga.es/',
            'phonenumber' => '+34 98 241 84 21 / 606 40 19 82',
            'Facebook' => 'https://www.facebook.com/Muferga-Museo-do-Ferrocarril-de-Galicia-181997725160307/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Museo del Ferrocarril de Ponferrada',
            'country_id' => 724,
            'city' => 'Ponferrada',
            'zip' => '24400',
            'email' => 'museoferrocarril@ponferrada.org',
            'address' => 'Alcalde García Arias, 7',
            'phonenumber' => '+34 987 405 738',
        ]);

        DB::table('Company')->insert([
            'name' => 'Museo del Tren de Aranda de Duero',
            'country_id' => 724,
            'city' => 'Aranda del Duero (Burgos)',
            'zip' => '09400',
            'address' => 'Estación Chelva, s/n',
            'website' => 'http://web.archive.org/web/20130731061320/http://www.museodeltren.com/',
            'phonenumber' => '+34 947 510 476',
        ]);

        DB::table('Company')->insert([
            'name' => 'Museo Ferrocarrilero John Trulock',
            'country_id' => 724,
            'address' => 'Iría Flavia',
            'city' => 'Padón (A Coruña)',
            'website' => 'http://www.concellodepadron.es/es',
            'phonenumber' => '+34 981 810 451',
        ]);

        DB::table('Company')->insert([
            'name' => 'Museo Vasco del Ferrocarril',
            'country_id' => 724,
            'address' => 'c/Julián Elorza 8',
            'city' => 'Azpeita (Guipuzcoa)',
            'zip' => '20730',
            'email' => 'museoa@euskotren.eus',
            'website' => 'http://www.bemfundazioa.org/?queidioma=1',
            'phonenumber' => '+34 943 15 06 77',
        ]);

        /*************
         ** GERMANY **
         *************/

        DB::table('Company')->insert([
            'name' => 'Aar Valley Railway working group',
            'country_id' => 276,
            'address' => 'Aar Valley Railway working group',
            'city' => 'Oberneisen',
            'zip' => '65558',
            'email' => 'info@arbeitskreis-aartalbahn.de',
            'website' => 'http://www.arbeitskreis-aartalbahn.de/',
        ]);

        DB::table('Company')->insert([
            'name' => 'AG Märkische Kleinbahn',
            'country_id' => 276,
            'address' => 'Goerzallee 313-315',
            'city' => 'Berlin-Lichterfelde',
            'zip' => '14167',
            'email' => 'formulari: http://www.zeuhag.de/mailform/mitteilg.php',
            'website' => 'http://mkb-berlin.de/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Augsburg Railway Park',
            'country_id' => 276,
            'address' => 'Firnhaberstraße 22c',
            'city' => 'Augsburg',
            'zip' => '86159',
            'email' => 'service@bahnpark-augsburg.eu',
            'website' => 'http://www.bahnpark-augsburg.de/',
            'phonenumber' => '+49 (0)821 450 447-100',
        ]);

        DB::table('Company')->insert([
            'name' => 'Bavarian Localbahn Society (Bayerischer Localbahn Verein e.V.)',
            'country_id' => 276,
            'address' => 'Adlerfarnstrasse 19',
            'city' => 'München',
            'zip' => '80935',
            'email' => 'localbahnmuseum@t-online.de',
            'website' => 'http://www.localbahnverein.de/',
            'phonenumber' => '+49 1607859485',
        ]);

        DB::table('Company')->insert([
            'name' => 'Bavarian Railway Museum',
            'country_id' => 276,
            'address' => 'Am Hohen Weg 6a',
            'city' => 'Nördlingen',
            'zip' => ' 86720',
            'email' => 'info@bayerisches-eisenbahnmuseum.de',
            'website' => 'http://www.bayerisches-eisenbahnmuseum.de/',
            'phonenumber' => '+49 9083 / 340',
        ]);

        DB::table('Company')->insert([
            'name' => 'Bochum Dahlhausen Railway Museum (Eisenbahnmuseum Bochum)',
            'country_id' => 276,
            'address' => 'Dr.-C.-Otto-Straße 191',
            'city' => 'Bochum',
            'zip' => '44879',
            'email' => 'info@eisenbahnmuseum-bochum.de ',
            'website' => 'http://www.eisenbahnmuseum-bochum.de/',
            'phonenumber' => '+49 234 - 492516',
        ]);

        DB::table('Company')->insert([
            'name' => 'Burgsittensen Moor Railway (Moorbahn Burgsittensen e.V.)',
            'country_id' => 276,
            'address' => 'Hauptstr. 70',
            'city' => 'Tiste',
            'zip' => '27419',
            'email' => 'formulari: http://www.moorbahn.de/kontakt/',
            'website' => 'http://www.moorbahn.de/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Cuckoo Railway',
            'country_id' => 276,
            'address' => 'Bahnhofstraße 14',
            'city' => 'Elmstein/Pfalz',
            'zip' => '67471',
            'email' => 'formulari: http://speyer.technik-museum.de/en/kontakt/',
            'website' => 'http://www.elmstein.de/kuckucksbaehnel_museumsbahn_elmstein_pfalz.shtml',
        ]);

        /************
         ** MEXICO **
         ************/

        DB::table('Company')->insert([
            'name' => 'Ferrocarril Interoceanico',
            'country_id' => 484,
            'website' => 'http://www.rypn.org/rypn_files/articles/Articles/040201ndem/default.htm',
        ]);

        DB::table('Company')->insert([
            'name' => 'Museo del Ferrocarril de aguascalientes',
            'country_id' => 484,
            'address' => '28 de agosto s/n Barrio de la Estación, Plaza de las Tres Centurias',
            'city' => 'Aguascalientes',
            'website' => 'http://www.museosygalerias.com/museoferrocarrilero/historia.asp',
            'phonenumber' => '994 27 61 y 62',
            'Facebook' => 'https://www.facebook.com/MuseoFerrocarrilero/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Museo Nacional de los Ferrocarriles Mexicanos',
            'country_id' => 484,
            'address' => 'Calle 11 Norte 1005, esquina con 10 Poniente, Centro Histórico',
            'city' => 'Puebla',
            'zip' => '72000',
            'email' => 'museoferrocarriles@conaculta.gob.mx',
            'website' => 'http://museoferrocarrilesmexicanos.gob.mx/',
            'phonenumber' => '(222) 774 0105 y 06',
        ]);

        DB::table('Company')->insert([
            'name' => 'Yucatan railway Museum',
            'country_id' => 484,
            'address' => 'Calle 43 at Calle 48,',
            'city' => 'Mérida, Yucatan',
            'website' => 'http://www.yucatanliving.com/destinations/the-yucatan-railway-museum',
            'Facebook' => 'https://www.facebook.com/Yucatan-Railway-Museum-259057224241957/',
        ]);

        /************
         ** FRANCE **
         ************/

        DB::table('Company')->insert([
            'name' => 'Cité du Train',
            'country_id' => 250,
            'address' => '2 rue Alfred de Glehn',
            'city' => 'Mulhouse',
            'zip' => '68200',
            'email' => 'message@citedutrain.com',
            'website' => 'http://www.citedutrain.com/',
            'phonenumber' => '03 89 42 83 33',
        ]);

        DB::table('Company')->insert([
            'name' => 'Loco Vapeur R1199 (Associació)',
            'country_id' => 250,
            'address' => '2 rue du pont de l’Arche',
            'city' => 'Nantes',
            'zip' => '44000',
            'email' => 'formulari: http://r1199.aerius.fr/?2-contact.html',
            'website' => 'http://r1199.aerius.fr/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Musée des tramways à vapeur et des chemins de fer secondaires français',
            'country_id' => 250,
            'address' => 'Mairie de Butry-Sur-Oise',
            'city' => 'BUTRY-SUR-OISE',
            'zip' => '95430',
            'email' => 'formulari: http://musee-mtvs.com/nous-contacter/',
            'website' => 'http://musee-mtvs.com/',
            'phonenumber' => '+33 (0)1 34 73 04 40',
            'Facebook' => 'https://www.facebook.com/leMTVS/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Musée du Rail à Dinan',
            'country_id' => 250,
            'address' => 'Place du 11 Novembre 1918',
            'city' => 'Gare de Dinan',
            'zip' => '22100',
            'email' => 'contact@museedurail-dinan.com',
            'website' => 'http://www.museedurail-dinan.com/',
            'phonenumber' => '02 96 39 81 33',
            'Facebook' => 'https://www.facebook.com/museedurail',
        ]);

        DB::table('Company')->insert([
            'name' => 'Musée du Train à Guiscriff',
            'country_id' => 250,
            'address' => '117 rue de la gare',
            'city' => 'Gare de Guiscriff',
            'zip' => '56560',
            'email' => 'armarchdu.guiscriff@orange.fr',
            'website' => 'http://www.lagaredeguiscriff.com/mus%C3%A9e/',
            'phonenumber' => '02-97-34-15-80',
            'Facebook' => 'http://www.facebook.com/morbihan.garedeguiscriff',
        ]);

        DB::table('Company')->insert([
            'name' => 'Musée ferroviaire de Mornac-sur-Seudre',
            'country_id' => 250,
            'address' => '1 rue du Grimeau',
            'city' => 'Mornac-sur-Seudre',
            'zip' => '17113',
            'website' => 'http://musee-ferroviaire-mornac.jimdo.com/',
            'phonenumber' => '07.51.66.92.36',
        ]);

        DB::table('Company')->insert([
            'name' => 'Musée vivant du chemin de fer',
            'country_id' => 250,
            'address' => 'AJECTA Rotonde de Longueville, rue Louis Platriez',
            'city' => 'Longueville',
            'zip' => '77650',
            'email' => 'musee@ajecta.org',
            'website' => 'http://www.ajecta.fr/',
            'phonenumber' => '01 64 08 60 62',
        ]);

        DB::table('Company')->insert([
            'name' => 'Rosny-Rail',
            'country_id' => 250,
            'address' => '1bis Place des Martyrs de la Résistance',
            'city' => 'ROSNY-SOUS-BOIS',
            'zip' => '93110',
            'email' => 'contact@rosny-rail.fr',
            'website' => 'http://www.rosny-rail.fr/pages5/accueil.html',
            'phonenumber' => '01.41.60.44.74',
        ]);

        /************
         ** CANADA **
         ************/

        DB::table('Company')->insert([
            'name' => 'Musée ferroviaire canadien',
            'country_id' => 124,
            'address' => '110, rue Saint-Pierre, Saint-Constant, Montérégie',
            'city' => 'Saint-Constant',
            'email' => 'info@exporail.org',
            'website' => 'http://www.exporail.org/',
            'phonenumber' => '450 632-2410',
        ]);

        DB::table('Company')->insert([
            'name' => 'Saskatchewan Railroad Historical Association (SRHA)',
            'country_id' => 124,
            'address' => 'Box 21117',
            'city' => 'Saskatoon',
            'zip' => 'S7H 5N9',
            'email' => 'srha@saskrailmuseum.org',
            'website' => 'http://www.saskrailmuseum.org/',
            'phonenumber' => '(306) 382-9855',
        ]);

        DB::table('Company')->insert([
            'name' => 'Alberta Railway Museum',
            'country_id' => 124,
            'address' => '34 St. Edmonton',
            'city' => 'Alberta',
            'zip' => 'T5Y 6B4',
            'email' => 'formulari: http://www.albertarailwaymuseum.com/contact-us.html',
            'website' => 'http://www.albertarailwaymuseum.com/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Canadian Museum of Rail Travel',
            'country_id' => 124,
            'address' => '57 Van Horne St, S (Highway 3/95) downtown',
            'city' => 'Cranbrook',
            'zip' => 'V1C 4H9',
            'email' => 'mail@trainsdeluxe.com',
            'website' => 'http://www.trainsdeluxe.com/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Elgin County Railway Museum',
            'country_id' => 124,
            'address' => '225 Wellington Street',
            'city' => 'St. Thomas, Ontario',
            'zip' => 'N5R 2S6',
            'email' => 'thedispatcher@ecrm5700.org',
            'website' => 'http://ecrm5700.org/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Exporail canadian Museum',
            'country_id' => 124,
            'address' => '110, Saint-Pierre Street',
            'city' => 'Saint-Constant (Québec) ',
            'zip' => 'J5A 1G7',
            'email' => 'info@exporail.org',
            'website' => 'http://www.exporail.org/en/',
            'phonenumber' => '450 632-2410',
        ]);

        DB::table('Company')->insert([
            'name' => 'Halton County Radial Railway',
            'country_id' => 124,
            'address' => '13629 Guelph Line',
            'city' => 'Milton, Ontario',
            'zip' => 'L9T 5A2',
            'email' => 'streetcar@hcry.org',
            'website' => 'http://www.hcry.org/',
            'phonenumber' => '519-856-9802',
        ]);

        DB::table('Company')->insert([
            'name' => 'Memory Junction Railway Museum',
            'country_id' => 124,
            'address' => '60 Maplewood Ave',
            'city' => 'Brighton, ON',
            'zip' => 'K0K',
            'email' => '+1 613-475-0379',
        ]);

        DB::table('Company')->insert([
            'name' => 'New Brunswick Railway Museum',
            'country_id' => 124,
            'address' => '2847 Main Street',
            'city' => 'Hillsborough, New Brunswick',
            'zip' => 'E4H 2X7',
            'email' => 'info@nbrm.ca',
            'website' => 'http://www.nbrm.ca/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Northern Ontario Railroad Museum',
            'country_id' => 124,
            'address' => '26 Bloor St. Capreol',
            'city' => 'Ontario',
            'zip' => 'P0M 1H0',
            'email' => 'info@normhc.ca',
            'website' => 'http://normhc.ca/',
            'phonenumber' => '(705) 858 - 5050',
        ]);

        DB::table('Company')->insert([
            'name' => 'Port Moody Station Museum',
            'country_id' => 124,
            'address' => '2734 Murray St.',
            'city' => 'Port Moody, British Columbia',
            'zip' => 'V3H 1X2',
            'email' => 'info@portmoodymuseum.org',
            'website' => 'http://portmoodymuseum.org/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Railway Coastal Museum',
            'country_id' => 124,
            'address' => 'Newfoundland Railway Station, 495 Water Street West',
            'city' => 'Newfoundland',
            'email' => 'info@railwaycoastalmuseum.ca',
            'website' => 'http://www.railwaycoastalmuseum.ca/',
            'phonenumber' => '(709) 724-5929',
        ]);

        DB::table('Company')->insert([
            'name' => 'Railway Museum of Eastern Ontario',
            'country_id' => 124,
            'address' => '90 William St. W',
            'city' => 'Smiths Falls, ON',
            'zip' => 'K7A 5A5',
            'email' => 'info@rmeo.org',
            'website' => 'http://rmeo.org/',
            'phonenumber' => '613-283-5696',
        ]);

        DB::table('Company')->insert([
            'name' => 'Revelstoke Railway Museum',
            'country_id' => 124,
            'address' => '719 Track St W',
            'city' => 'Revelstoke',
            'zip' => 'V0E 2S0',
            'email' => 'railway@telus.net',
            'website' => 'http://www.railwaymuseum.com/',
            'phonenumber' => '+1 250-837-6060',
        ]);

        DB::table('Company')->insert([
            'name' => 'Toronto Railway Historical Association (Managers of the Toronto Railway Museum',
            'country_id' => 124,
            'address' => '255 Bremner Blvd, Unit 15 ',
            'city' => 'Toronto, ON',
            'zip' => 'M5V 3M9',
            'email' => 'info@trha.ca',
            'website' => 'http://www.trha.ca/index.html',
        ]);

        DB::table('Company')->insert([
            'name' => 'Toronto Railway Museum',
            'country_id' => 124,
            'address' => '255 Bremner Blvd',
            'city' => 'Toronto',
            'zip' => 'M5V 3M9',
            'email' => 'info@torontorailwaymuseum.com',
            'website' => 'http://www.torontorailwaymuseum.com/',
            'phonenumber' => '416-214-9229',
            'Facebook' => 'https://www.facebook.com/Toronto-Railway-Museum-338897312846580/',
        ]);

        DB::table('Company')->insert([
            'name' => 'West Coast Railway Association',
            'country_id' => 124,
            'address' => 'PO Box 2790 Stn. Term.',
            'city' => 'Vancouver, BC',
            'zip' => 'V6B 3X2',
            'email' => ' info@wcra.org',
            'website' => 'http://www.wcra.org/',
            'phonenumber' => '604-898-9336 or 1-800-722-1233',
        ]);

        DB::table('Company')->insert([
            'name' => 'Winnipeg Railway Museum',
            'country_id' => 124,
            'address' => '123 Main Street',
            'city' => 'Winnipeg MB',
            'zip' => 'R3T 1A3',
            'email' => 'wpgrail@mts.net',
            'website' => 'http://www.wpgrailwaymuseum.com/',
        ]);

        DB::table('Company')->insert([
            'name' => '',
            'country_id' => 124,
            'address' => '',
            'city' => '',
            'zip' => '',
            'email' => '',
            'website' => '',
            'phonenumber' => '',
            'Twitter' => '',
            'Facebook' => '',
            'LinkedIn' => '',
            'instagram' => '',
            'youtube' => '',
            'flickr' => '',
            'pinterest' => '',
        ]);

        /***********
         ** CHILE **
         ***********/

        DB::table('Company')->insert([
            'name' => 'Museo Ferroviario de Santiago de Chile',
            'country_id' => 152,
            'address' => 'Interior Parque Quinta Normal s/n',
            'city' => 'Santiago de Chile',
            'zip' => 'mferroviario@tie.cl',
            'email' => 'http://www.corpdicyt.cl/mferroviario/',
        ]);


        /********************
         ** CZECH REPUBLIK **
         ********************/

        DB::table('Company')->insert([
            'name' => 'National Technical Museum',
            'country_id' => 203,
            'address' => 'Kostelní 42',
            'city' => 'Prague',
            'zip' => '170 78',
            'email' => 'info@ntm.cz',
            'website' => 'http://www.ntm.cz/en',
            'phonenumber' => '+420 220 399 111',
            'Twitter' => '',
            'Facebook' => '',
            'LinkedIn' => '',
            'instagram' => '',
            'youtube' => '',
            'flickr' => '',
            'pinterest' => '',
        ]);


        /*************
         ** HOLLAND **
         *************/

        DB::table('Company')->insert([
            'name' => 'Noord-Nederlands Trein & Tram Museum',
            'country_id' => 528,
            'address' => 'PO Box 5',
            'city' => 'Zuidbroek',
            'zip' => '9636 ZG',
            'email' => 'formulari: http://www.nnttm.nl/contact/',
            'website' => 'http://www.nnttm.nl/',
            'phonenumber' => '0598-45 36 96',
        ]);

        DB::table('Company')->insert([
            'name' => 'Railway Museum (Netherlands)',
            'country_id' => 528,
            'address' => 'Maliebaanstation',
            'city' => 'Utrecht',
            'zip' => '3581 XW',
            'email' => 'info@spoorwegmuseum.nl',
            'website' => 'http://www.spoorwegmuseum.nl/',
        ]);

        DB::table('Company')->insert([
            'name' => 'Stoom Stichting Nederland',
            'country_id' => 528,
            'address' => 'Rolf Hartkoornweg 50',
            'city' => 'Rotterdam',
            'zip' => '3034 KL',
            'email' => 'formulari: https://intra.stoomstichting.nl/Public_Forms/Contact_NL.php',
            'website' => 'http://www.stoomstichting.nl/Display.php?Subject=Home',
        ]);

        DB::table('Company')->insert([
            'name' => 'Stoomtrein Valkenburgse Meer',
            'country_id' => 528,
            'address' => 'Jan Pellenbargweg 1',
            'city' => 'Valkenburg',
            'zip' => '2235 SP',
            'email' => 'info@StoomtreinKatwijkLeiden.nl',
            'website' => 'http://www.stoomtreinkatwijkleiden.nl/',
            'phonenumber' => '(071) 572 4275',
        ]);

        DB::table('Company')->insert([
            'name' => 'Veluwsche Stoomtrein Maatschappij',
            'country_id' => 528,
            'address' => 'Rijnstraat 68 ',
            'city' => 'Apeldoorn',
            'zip' => '7332 AX',
            'email' => 'info@stoomtrein.org',
            'website' => 'http://www.stoomtrein.org/',
            'phonenumber' => '055-506 1989',
        ]);

        DB::table('Company')->insert([
            'name' => 'Zuid-Limburgse Stoomtrein Maatschappij',
            'country_id' => 528,
            'address' => 'Stationstraat 20-22',
            'city' => 'Simpelveld',
            'zip' => '6369 VJ',
            'email' => 'info@miljoenenlijn.nl',
            'website' => 'http://www.zlsm.nl/',
            'phonenumber' => '+31 (0) 45 544 00 18',
        ]);



        /***** TEMPLATE *****/


        /*

        DB::table('Company')->insert([
            'name' => '',
            'country_id' => 528,
            'address' => '',
            'city' => '',
            'zip' => '',
            'email' => '',
            'website' => '',
            'phonenumber' => '',
            'Twitter' => '',
            'Facebook' => '',
            'LinkedIn' => '',
            'instagram' => '',
            'youtube' => '',
            'flickr' => '',
            'pinterest' => '',
        ]);


        */
    }
}