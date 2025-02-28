# Descripció del projecte

El projecte **VideosApp** consisteix en la creació d'una aplicació web similar a YouTube, on es gestionaran usuaris, vídeos i llistes. A través de diversos sprints, s'implementaran les funcionalitats bàsiques de l'aplicació, incloent la creació i visualització de vídeos, gestió d'usuaris i altres operacions relacionades amb la visualització de contingut.

---

## Sprint 1: Creació del projecte i configuració inicial

### 1. Creació del projecte
Es va crear un projecte Laravel anomenat **'VideosAppPau'**, configurant els següents elements:

- **Jetstream amb Livewire**: Per gestionar l'autenticació i les interaccions dinàmiques.
- **PHPUnit**: Per realitzar proves unitàries.
- **Teams**: Per gestionar equips d'usuaris dins de l'aplicació.
- **SQLite**: Com a base de dades temporal per al desenvolupament inicial.

### 2. Test de helpers
Es va crear un test per verificar la creació de dos tipus d'usuari:

- **Usuari per defecte** amb camps com name, email i password.
- **Usuari professor**, també amb la mateixa estructura.

A més, la contrasenya es va encriptar i els usuaris es van associar a un equip per defecte.

### 3. Configuració de helpers i credencials
Es van crear **helpers** dins la carpeta app per facilitar tasques repetitives, i es va configurar el fitxer config per utilitzar les credencials d'usuaris per defecte carregades des del fitxer .env.

---

## Sprint 2: Migracions, models i proves

### 1. Correcció d'errors
Es van corregir diversos errors detectats durant el primer sprint, incloent l'ús d'una base de dades temporal per als tests, el que va permetre garantir un entorn net i controlat per les proves.

### 2. Migració de vídeos
Es va crear una migració per a la taula de **vídeos** amb els següents camps:

- **id**: Identificador únic del vídeo.
- **title**: Títol del vídeo.
- **description**: Descripció del vídeo.
- **url**: Enllaç al vídeo.
- **published_at**: Data de publicació.
- **previous**: Referència al vídeo anterior (si escau).
- **next**: Referència al vídeo següent (si escau).
- **series_id**: Identificador de la sèrie a la qual pertany el vídeo.

### 3. Controlador i model de vídeos
Es va implementar el controlador **VideosController** amb dues funcions principals:

- **testedBy**: Per realitzar proves específiques associades als vídeos.
- **show**: Per mostrar un vídeo específic.

A més, es va crear el model de **Vídeos** amb funcions per formatar les dates de publicació utilitzant la llibreria **Carbon**.

### 4. Helpers de vídeos per defecte
Es va crear un helper per afegir vídeos per defecte a la base de dades, facilitant així les proves i el desenvolupament inicial.

### 5. Afegir usuaris i vídeos per defecte
Es va configurar el **DatabaseSeeder** per afegir usuaris i vídeos per defecte a la base de dades, assegurant-se que l'aplicació disposés de dades de prova per als tests.

### 6. Creació de layout i rutes
Es va crear el layout **VideosAppLayout**, que es va utilitzar per estructurar les vistes de l'aplicació. A més, es van definir les rutes per mostrar els vídeos en el frontend.

### 7. Proves de vídeos
Es van crear diverses proves per garantir el correcte funcionament de les funcionalitats de vídeos, incloent:

- Creació de vídeos per defecte.
- Visualització correcta dels vídeos.
- Accés als vídeos per part dels usuaris, incloent proves de permisos i validacions de l'usuari autenticat.

---

## Sprint 3: Funcionalitats d'usuaris, permisos i tests

### 1. Corregir els errors del 2n sprint
Es van corregir els errors detectats durant el segon sprint.

### 2. Instal·lació de spatie/laravel-permission
Es va instal·lar el paquet spatie/laravel-permission per gestionar els rols i permisos dels usuaris dins de l'aplicació, seguint la documentació oficial per a la instal·lació.

### 3. Migració per afegir el camp super_admin
Es va crear una migració per afegir el camp super_admin a la taula **users**.

### 4. Afegir funcions al model d'usuaris
Es va afegir la funció testedBy() i la funció isSuperAdmin() al model d'usuari per gestionar la lògica dels permisos.

### 5. Funcions per a la creació d'usuaris
Es va crear la funció create_default_professor() per afegir el superadmin al professor, així com altres funcions per crear usuaris de tipus **regular**, **video manager** i **superadmin**:

- **create_regular_user()**
- **create_video_manager_user()**
- **create_superadmin_user()**

A més, es va implementar la funció define_gates() per definir les portes d'autorització i les funcions create_permissions() per crear permisos predeterminats.

### 6. Política d'autorització
A la funció book de **AppServiceProvider**, es van registrar les polítiques d'autorització i es van definir les portes d'accés per gestionar els permisos dels usuaris.

### 7. Afegir usuaris i permisos al DatabaseSeeder
Es van afegir usuaris per defecte (superadmin, regular user, video manager) i permisos al **DatabaseSeeder** per garantir que els usuaris i els rols es creessin correctament en la base de dades.

### 8. Publicar els stubs
Es va publicar els stubs per personalitzar la generació de fitxers, seguint la guia de Laravel per personalitzar els stubs.

### 9. Crear tests de vídeos
Es va crear el test **VideosManageControllerTest** dins de la carpeta tests/Feature/Videos, amb les funcions següents per comprovar la gestió de vídeos:

- user_with_permissions_can_manage_videos()
- regular_users_cannot_manage_videos()
- guest_users_cannot_manage_videos()
- superadmins_can_manage_videos()
- loginAsVideoManager()
- loginAsSuperAdmin()
- loginAsRegularUser()

### 10. Crear test d'usuaris
Es va crear el test **UserTest** a la carpeta tests/Unit, amb la funció isSuperAdmin() per validar la lògica associada als superadmins.

### 11. Afegir documentació
Es va afegir la descripció dels sprints a **resources/markdown/terms** per mantenir la documentació del projecte actualitzada.

### 12. Comprovar fitxers amb Larastan
Es va utilitzar **Larastan** per comprovar els fitxers creats i assegurar la qualitat del codi.

---

## Sprint 4: Implementació del CRUD de vídeos i millores d'interfície

### 1. Correcció dels errors del 3r sprint
Es van corregir els errors detectats durant el tercer sprint, incloent la verificació dels permisos d'accés a la ruta `/videosmanage` per part dels usuaris amb permisos corresponents.

### 2. Creació del VideosManageController
Es va crear el controlador **VideosManageController** amb les següents funcions:

- **testedBy**: Per realitzar proves específiques associades al controlador.
- **index**: Per mostrar la llista de vídeos.
- **store**: Per emmagatzemar un nou vídeo.
- **show**: Per mostrar un vídeo específic.
- **edit**: Per mostrar el formulari d'edició d'un vídeo.
- **update**: Per actualitzar un vídeo existent.
- **delete**: Per mostrar la confirmació d'eliminació d'un vídeo.
- **destroy**: Per eliminar un vídeo.

### 3. Implementació de la funció index a VideosController
Es va implementar la funció **index** al controlador **VideosController** per mostrar tots els vídeos disponibles.

### 4. Revisió i creació de vídeos per defecte
Es va revisar que hi haguessin 3 vídeos creats als helpers i afegits al **DatabaseSeeder** per garantir que les dades de prova estiguessin disponibles per als tests.

### 5. Creació de vistes per al CRUD de vídeos
Es van crear les següents vistes per gestionar el CRUD de vídeos, accessibles només pels usuaris amb els permisos corresponents:

- **resources/views/videos/manage/index.blade.php**: Vista per mostrar la llista de vídeos amb una taula CRUD.
- **resources/views/videos/manage/create.blade.php**: Vista amb el formulari per crear un nou vídeo, utilitzant l'atribut `data-qa` per facilitar els tests.
- **resources/views/videos/manage/edit.blade.php**: Vista amb el formulari per editar un vídeos existent.
- **resources/views/videos/manage/delete.blade.php**: Vista per confirmar l'eliminació d'un vídeo.

### 6. Implementació de la vista principal de vídeos
Es va crear la vista **resources/views/videos/index.blade.php** per mostrar tots els vídeos de manera similar a la pàgina principal de YouTube. En clicar a un vídeo, es redirigeix a la vista de detall (show) implementada en sprints anteriors.

### 7. Modificació del test user_with_permissions_can_manage_videos
Es va modificar el test **user_with_permissions_can_manage_videos** per assegurar-se que hi haguessin 3 vídeos disponibles per a les proves.

### 8. Creació de permisos per al CRUD de vídeos
Es van crear permisos específics per al CRUD de vídeos als helpers i assignar-los als usuaris corresponents (superadmin, video manager, etc.).

### 9. Creació de tests addicionals
Es van crear les següents funcions de test:

- **VideoTest**:
    - user_without_permissions_can_see_default_videos_page
    - user_with_permissions_can_see_default_videos_page
    - not_logged_users_can_see_default_videos_page

- **VideosManageControllerTest**:
    - loginAsVideoManager
    - loginAsSuperAdmin
    - loginAsRegularUser
    - user_with_permissions_can_see_add_videos
    - user_without_videos_manage_create_cannot_see_add_videos
    - user_with_permissions_can_store_videos
    - user_without_permissions_cannot_store_videos
    - user_with_permissions_can_destroy_videos
    - user_without_permissions_cannot_destroy_videos
    - user_with_permissions_can_see_edit_videos
    - user_without_permissions_cannot_see_edit_videos
    - user_with_permissions_can_update_videos
    - user_without_permissions_cannot_update_videos
    - user_with_permissions_can_manage_videos
    - regular_users_cannot_manage_videos
    - guest_users_cannot_manage_videos
    - superadmins_can_manage_videos

### 10. Configuració de rutes per al CRUD de vídeos
Es van configurar les rutes per al CRUD de vídeos sota el prefix `/videos/manage`, amb middleware per garantir que només els usuaris autenticats puguin accedir-hi. La ruta de l'índex de vídeos es va configurar per ser accessible tant per usuaris autenticats com no autenticats.

### 11. Afegir navbar i footer a la plantilla
Es va afegir un **navbar** i un **footer** a la plantilla **resources/layouts/videosapp.blade.php** per permetre la navegació entre pàgines de manera consistent.

### 12. Actualització de la documentació
Es va afegir la descripció del quart sprint al fitxer **resources/markdown/terms.md** per mantenir la documentació del projecte actualitzada.

### 13. Comprovació de fitxers amb Larastan
Es va utilitzar **Larastan** per comprovar tots els fitxers creats durant aquest sprint, assegurant la qualitat i l'estandardització del codi.

---

**Conclusió:**
Amb aquest quart sprint, s'ha implementat el CRUD complet per a la gestió de vídeos, juntament amb les vistes necessàries i els tests corresponents. A més, s'ha millorat la interfície d'usuari amb l'addició d'un navbar i un footer. Els pròxims passos inclouran la implementació de funcionalitats addicionals i millores en l'experiència d'usuari.
