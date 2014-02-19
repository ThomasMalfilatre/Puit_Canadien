function placer_puit(){

	var sphereGeometry = new THREE.SphereGeometry( 10, 32, 16 ); 	
	var mat = new THREE.MeshBasicMaterial( {color: "rgb(0,0,0)", wireframe:true} );
	var mesh = new THREE.Mesh(sphereGeometry, mat);
	var mesh1 = new THREE.Mesh(sphereGeometry, mat);
	var mesh2 = new THREE.Mesh(sphereGeometry, mat);
	mesh.position.set(850,370,550);
	mesh1.position.set(-500,20,550);
	mesh2.position.set(-850,370, 550);
	mesh.name = "Puit Canadien";
	mesh1.name = "Puit Canadien";
	mesh2.name = "Puit Canadien";
	scene.add(mesh);
	scene.add(mesh1);
	scene.add(mesh2);

	var Geo = new THREE.CylinderGeometry(10, 10, 200, 8, 1, true); 
	var Geo2 = new THREE.CylinderGeometry(10, 10, 1395, 8, 1, true); 
	var Geo3 = new THREE.CylinderGeometry(10, 10, 495, 8, 1, true); 
	var p = new THREE.Mesh(Geo, mat);
	p.position.set(850,470,550);
	p.name = "Puit Canadien";
	scene.add(p);
	var p1 = new THREE.Mesh(Geo2, mat);
	p1.position.set(175,195,550);
	p1.rotation.z = 284.5 * (Math.PI / 180);
	p1.name = "Puit Canadien";
	scene.add(p1);
	var p2 = new THREE.Mesh(Geo3, mat);
	p2.position.set(-675,195,550);
	p2.rotation.z = -135 * (Math.PI / 180);
	p2.name = "Puit Canadien";
	scene.add(p2);
	var p3 = new THREE.Mesh(Geo, mat);
	p3.position.set(-850,470,550);
	p3.name = "Puit Canadien";
	scene.add(p3);
}