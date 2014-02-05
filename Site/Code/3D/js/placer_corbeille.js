function placer_corbeille(nom, x, y, z){
	var Geo = new THREE.CylinderGeometry(6, 6, 400, 8, 1, true); 
	var Mat = new THREE.MeshBasicMaterial({color:"rgb(255,255,255)",wireframe:true})
	var corb = new THREE.Mesh(Geo, Mat);
	corb.name = "Corbeille "+nom;
	corb.position.set(x,y,z);
	scene.add(corb);
}