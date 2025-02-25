function calculPrix(noeuds) {
    let distance = 0;

    for (const noeud in noeuds) {
        distance += noeud.noe_distance_prochain;
    }

    return distance / 10; 
}