/*** MAIN ***/

/* http://www.alsacreations.com/tuto/lire/1572-webgl-3d-three-canvas-threejs.html */

// declaration des variable globale

var container, scene, camera, renderer, controls, stats;
var keyboard = new THREEx.KeyboardState();
var clock = new THREE.Clock();
var cube;

var SCREEN_WIDTH = window.innerWidth - 350;
var SCREEN_HEIGHT = window.innerHeight - 200; 
var VIEW_ANGLE = 45;
var ASPECT = SCREEN_WIDTH / SCREEN_HEIGHT;
var NEAR = 0.1;
var FAR = 20000;

var projector, projector2, mouse = { x: 0, y: 0 }, INTERSECTED;
var sprite1;
var canvas1, context1, texture1;
var targetList = []; // liste des sondes selectionnable
var selected = []; // liste des sondes selectionne

/*** INITIALISATION ***/
init();

/*** ANIMATION (BOUCLE)***/
animate();

/*** FONCTIONS ***/

function unset(array, value){
	var output=[];
	var index = array.indexOf(value)
	var j = 0;
	for(var i in array){
		if (i!=index){
			output[j]=array[i];
			j++;
		}
	}
	return output;
}

function init(){

	// scene
	scene = new THREE.Scene();

	// camera

	camera = new THREE.PerspectiveCamera( VIEW_ANGLE, ASPECT, NEAR, FAR);
	scene.add(camera);
	camera.position.set(0,800,2800);

	// renderer
	if ( Detector.webgl )
		renderer = new THREE.WebGLRenderer( {antialias:true} );
	else
		renderer = new THREE.CanvasRenderer(); 

	renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
	// attache le rendu a la div container
	container = document.getElementById( 'container' );
	container.appendChild( renderer.domElement );

	// events
	// ajuste automatiquement le rendu si on redimensionne la fenetre
	THREEx.WindowResize(renderer, camera);
	
	// controls

	// move mouse and: left   click to rotate, 
	//                 middle click to zoom, 
	//                 right  click to pan
	controls = new THREE.OrbitControls( camera, renderer.domElement );

	// stats

	stats = new Stats();
	stats.domElement.style.position = 'absolute';
	stats.domElement.style.bottom = '0px';
	stats.domElement.style.zIndex = 100;
	container.appendChild( stats.domElement );

	// light

	var light = new THREE.PointLight(0xffffff);
	light.position.set(0,250,1000);
	scene.add(light);

	//axes
	var axes = new THREE.AxisHelper(500);
	// scene.add( axes );

	var floorGeometryArr = new THREE.PlaneGeometry(1800, 420, 1, 1);
	var floorGeometry = new THREE.PlaneGeometry(1800, 600, 1, 1);
	var wallGeometry = new THREE.PlaneGeometry(600, 420,1,1);
	
	/* B32 */
	var textureB32 = THREE.ImageUtils.loadTexture('3D/js/texture/B32.jpg');
	textureB32.wrapS = textureB32.wrapT = THREE.RepeatWrapping;
	var B32Material = new THREE.MeshBasicMaterial({map: textureB32 , side: THREE.DoubleSide});
	var B32Geometry = new THREE.PlaneGeometry(1800, 420, 1, 1);
	var B32 = new THREE.Mesh(B32Geometry, B32Material);
	B32.position.set(0,630,0);
	scene.add(B32);
	
	/* CAFET */
	var textureCafet = THREE.ImageUtils.loadTexture('3D/js/texture/Cafet.jpg');
	textureCafet.wrapS = textureCafet.wrapT = THREE.RepeatWrapping;
	var CafetMaterial = new THREE.MeshBasicMaterial({map: textureCafet , side: THREE.DoubleSide});
	var CafetGeometry = new THREE.PlaneGeometry(600, 420,1,1);
	var Cafet = new THREE.Mesh(CafetGeometry, CafetMaterial);
	Cafet.position.set(900,630,300);
	Cafet.rotation.y = - Math.PI /2;
	// Cafet.rotation.z = Math.PI;
	scene.add(Cafet);
	
	/* GTE */
	var textureGTE = THREE.ImageUtils.loadTexture('3D/js/texture/GTE.jpg');
	textureGTE.wrapS = textureGTE.wrapT = THREE.RepeatWrapping;
	var GTEMaterial = new THREE.MeshBasicMaterial({map: textureGTE , side: THREE.DoubleSide});
	var GTEGeometry = new THREE.PlaneGeometry(600, 420,1,1);
	var GTE = new THREE.Mesh(GTEGeometry, GTEMaterial);
	GTE.position.set(-900,630,300);
	GTE.rotation.y = Math.PI /2;
	scene.add(GTE);	

	// sol
	var groundMaterial = new THREE.MeshBasicMaterial({color:"rgb(127,221,76)", side: THREE.DoubleSide, transparent: true, opacity: 0.5}); //vert
	var floorMaterial = new THREE.MeshBasicMaterial({color:"rgb(139,105,20)", side: THREE.DoubleSide}); //marron
	var floorTransMaterial = new THREE.MeshBasicMaterial({color:"rgb(139,105,20)", transparent: true, opacity: 0.5 , side: THREE.DoubleSide}); //marron transparent
	var floor = new THREE.Mesh(floorGeometry, groundMaterial);
	var fond = new THREE.Mesh(floorGeometry, floorMaterial);
	var arriere = new THREE.Mesh(floorGeometryArr, floorMaterial);
	floor.position.set(0,420,300);
	floor.rotation.x = Math.PI / 2;
	scene.add(floor);
	fond.position.set(0,0,300);0
	fond.rotation.x = Math.PI / 2;
	scene.add(fond);
	arriere.position.set(0,210,0);
	scene.add(arriere);

	var gauche = new THREE.Mesh(wallGeometry, floorTransMaterial);
	gauche.position.set(-900,210,300);
	gauche.rotation.y = Math.PI /2;
	scene.add(gauche);
	
	var droite = new THREE.Mesh(wallGeometry, floorTransMaterial);
	droite.position.set(900,210,300);
	droite.rotation.y = Math.PI /2;
	scene.add(droite);


	
	var Geo = new THREE.CylinderGeometry(6, 6, 420, 8, 1, true); 
	var Mat = new THREE.MeshBasicMaterial({color:"rgb(0,0,0)",wireframe:false})
	var coin = new THREE.Mesh(Geo, Mat);
	coin.position.x = 900;
	coin.position.y = 620;
	scene.add(coin);
	var coin2 = new THREE.Mesh(Geo, Mat);
	coin2.position.x = -900;
	coin2.position.y = 620;
	scene.add(coin2);

	/* VMC */

	var vmcMaterial = new THREE.MeshBasicMaterial({color: 0x000000, wireframe:true})
	var vmcGeometry = new THREE.PlaneGeometry(200, 200, 6, 6);
	var vmch = new THREE.Mesh(vmcGeometry, vmcMaterial);
	vmch.position.set(-800,840,500);
	vmch.rotation.x = Math.PI/2;
	vmch.name = "vmc";
	scene.add(vmch);

	var vmcarr = new THREE.Mesh(vmcGeometry, vmcMaterial);
	vmcarr.position.set(-800,740,400)
	vmcarr.name = "vmc";
	scene.add(vmcarr);

	var vmcd = new THREE.Mesh(vmcGeometry, vmcMaterial);
	vmcd.position.set(-700,740,500)
	vmcd.rotation.y = Math.PI/2;
	vmcd.name = "vmc";
	scene.add(vmcd);


	// var vmcGeometry = new THREE.CubeGeometry( 200, 200, 200 ); 
	// var vmcMaterial = new THREE.MeshBasicMaterial( {color: 0x00ff00, wireframe:true }); 
	// var vmc = new THREE.Mesh( vmcGeometry, vmcMaterial ); 
	// vmc.position.x = -800
	// vmc.position.y = 700
	// vmc.position.z = 400
	// // scene.add( vmc );

	// initialize object to perform world/screen calculations
	projector = new THREE.Projector();
	document.addEventListener( 'mousemove', onDocumentMouseMove, false );
	
	/////// draw text on canvas /////////
	// create a canvas element
	canvas1 = document.createElement('canvas');
	context1 = canvas1.getContext('2d');
	context1.font = "Bold 20px Arial";
	context1.fillStyle = "rgba(0,0,0,0.95)";
    context1.fillText('Hello, world!', 0, 20);
    
	// canvas contents will be used for a texture
	texture1 = new THREE.Texture(canvas1) 
	texture1.needsUpdate = true;
	
	var spriteMaterial = new THREE.SpriteMaterial( { map: texture1, useScreenCoordinates: true, alignment: THREE.SpriteAlignment.topLeft } );
	sprite1 = new THREE.Sprite( spriteMaterial );
	sprite1.scale.set(200,100,1.0);
	
	sprite1.position.set( 0, 0, 0 );
	scene.add( sprite1 );	

	projector2 = new THREE.Projector();
	document.addEventListener( 'mousedown', onDocumentMouseDown, false);
}

function onDocumentMouseMove( event ){
	// update sprite position
	sprite1.position.set( event.clientX -300 , event.clientY -140- 20, 0 );

	// update the mouse variable
	mouse.x = ( (event.clientX -300) / SCREEN_WIDTH ) * 2 - 1;
	mouse.y = - ( (event.clientY -140) / SCREEN_HEIGHT ) * 2 + 1;
}

function onDocumentMouseDown( event ){

	// update the mouse variable
	mouse.x = ( (event.clientX -300) / SCREEN_WIDTH ) * 2 - 1;
	mouse.y = - ( (event.clientY -140) / SCREEN_HEIGHT ) * 2 + 1;

	// find intersections

	// create a Ray with origin at the mouse position
	//   and direction into the scene (camera direction)
	var vector = new THREE.Vector3( mouse.x, mouse.y, 1 );
	projector2.unprojectVector( vector, camera );
	var ray = new THREE.Raycaster( camera.position, vector.sub( camera.position ).normalize() );

	// create an array containing all objects in the scene with which the ray intersects
	var intersects = ray.intersectObjects( targetList );

	// if there is one (or more) intersections
	if ( intersects.length > 0 ){
		console.log("Hit @ " + toString( intersects[0].point ) );
		console.log(intersects[0].object.name);

		intersects[ 0 ].object.material.color.setRGB( 0, 0, 0 );
		intersects[ 0 ].object.geometry.colorsNeedUpdate = true;
		
		var trouve = false;
		for(var i=0;i<selected.length;i++)
			if(intersects[0].object.name == selected[i].name)
				trouve = true;

		if(!trouve)
			selected.push(intersects[0].object);
		else
			selected = unset(selected, intersects[0].object);

		var str = "";
		for(var i=0;i<selected.length;i++)
			str += selected[i].name + "<br />";
		// alert(str);

		var liste = document.getElementById( 'baseSondes' );
		// liste.write(str);
		document.getElementById('baseSondes').innerHTML = str;
		document.getElementById('Sondes').value = str;
	}
}

function listeSondes(){
	var str = "";
	for(var i=0;i<selected.length;i++)
		str += selected[i].name + "\n";
	return str;	
}

function toString(v) { return "[ " + v.x + ", " + v.y + ", " + v.z + " ]"; }

function animate(){
    requestAnimationFrame( animate );
	render();		
	update();
}

function update(){
	// delta = change in time since last call (in seconds)
	var delta = clock.getDelta(); 
	//console.log("position : "+camera.position.x+","+camera.position.y+","+camera.position.z);

	// create a Ray with origin at the mouse position
	//   and direction into the scene (camera direction)
	var vector = new THREE.Vector3( mouse.x, mouse.y, 1 );
	projector.unprojectVector( vector, camera );
	var ray = new THREE.Raycaster( camera.position, vector.sub( camera.position ).normalize() );
	// create an array containing all objects in the scene with which the ray intersects
	var intersects = ray.intersectObjects( scene.children );
	// INTERSECTED = the object in the scene currently closest to the camera 
	//		and intersected by the Ray projected from the mouse position 	
	// if there is one (or more) intersections
	if ( intersects.length > 0 ){
		// if the closest object intersected is not the currently stored intersection object
		if ( intersects[ 0 ].object != INTERSECTED ){
		    // restore previous intersection object (if it exists) to its original color
			if ( INTERSECTED ) 
				INTERSECTED.material.color.setHex( INTERSECTED.currentHex );
			// store reference to closest object as current intersection object
			INTERSECTED = intersects[ 0 ].object;
			// store color of closest object (for later restoration)
			INTERSECTED.currentHex = INTERSECTED.material.color.getHex();
			// set a new color for closest object

			// update text, if it has a "name" field.
			if ( intersects[ 0 ].object.name ){
				INTERSECTED.material.color.setHex( 0xffffff );
			    context1.clearRect(0,0,640,480);
				var message = intersects[ 0 ].object.name;
				var metrics = context1.measureText(message);
				var width = metrics.width;
				context1.fillStyle = "rgba(0,0,0,0.95)"; // black border
				context1.fillRect( 0,0, width+8,20+8);
				context1.fillStyle = "rgba(255,255,255,0.95)"; // white filler
				context1.fillRect( 2,2, width+4,20+4 );
				context1.fillStyle = "rgba(0,0,0,1)"; // text color
				context1.fillText( message, 4,20 );
				texture1.needsUpdate = true;
			}
			else{
				context1.clearRect(0,0,300,300);
				texture1.needsUpdate = true;
			}
		}
	} 
	else{ // there are no intersections
		// restore previous intersection object (if it exists) to its original color
		if ( INTERSECTED ) 
			INTERSECTED.material.color.setHex( INTERSECTED.currentHex );
		// remove previous intersection object reference
		//     by setting current intersection object to "nothing"
		INTERSECTED = null;
		context1.clearRect(0,0,300,300);
		texture1.needsUpdate = true;
	}

	controls.update();
	stats.update();
}

function render(){	
	renderer.render( scene, camera );
}
