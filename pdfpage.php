<?php
require('C:\wamp64\www\FAC\cserveur\FPDF-master (1)\FPDF-master\fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',7);

try {
    $bdd = new PDO('mysql:host=localhost;dbname=dsi22g1;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$reponse = $bdd->query("SELECT j.idj, (SELECT COUNT(DISTINCT m.idm) FROM matchs m, marquer_but b WHERE b.idj = j.idj AND m.idm = b.idm) AS Match_joues, (SELECT SUM(b.nbr_but) FROM marquer_but b WHERE b.idj = j.idj) AS nbr_but FROM joueur j");
$pdf->SetDrawColor(0,80,180);
$pdf->SetTextColor(0,80,180);
$pdf->Cell(30, 10, 'ID Joueur', 1);
$pdf->Cell(30, 10, 'Nombre Matchs Joues', 1);
$pdf->Cell(30, 10, 'Buts Match', 1);
$pdf->Cell(30, 10, 'Age Moyen', 1);
$pdf->Cell(30, 10, 'Meilleur Joueur', 1);
$pdf->Ln();

$pdf->SetTextColor(0,0,0,0);
$pdf->SetFont('Arial','',10);
$ageMoyStmt = $bdd->query("SELECT AVG(age) AS Age FROM joueur");
$ageMoy = $ageMoyStmt->fetch()['Age'];
$joueurMAX = $bdd->query("SELECT j.nom AS nom FROM joueur j, marquer_but b WHERE j.idj = b.idj AND b.nbr_but = (SELECT MAX(b2.nbr_but) AS max_but FROM marquer_but b2)");
$joueur = $joueurMAX->fetch()['nom'];
while ($donnees = $reponse->fetch()) {
    $pdf->Cell(30, 10, $donnees['idj'], 1);
    $pdf->Cell(30, 10, $donnees['Match_joues'], 1);
    $pdf->Cell(30, 10, $donnees['nbr_but'], 1);
    $pdf->Cell(30, 10, $ageMoy, 1);
    $pdf->Cell(30, 10, $joueur, 1);
    $pdf->Ln();}
    $pdf->Ln();

$pdf->SetDrawColor(0,80,180);
$pdf->SetTextColor(0,80,180);
$pdf->Cell(30, 10, 'ID Match', 1);
$pdf->Cell(30, 10, 'Equipe 1', 1);
$pdf->Cell(30, 10, 'Equipe 2', 1);
$pdf->Cell(30, 10, 'Buts', 1);
$pdf->Ln();

$pdf->SetTextColor(0,0,0,0);
$pdf->SetFont('Arial','',10);
$ageMoyStmt = $bdd->query("SELECT AVG(age) AS Age FROM joueur");
$ageMoy = $ageMoyStmt->fetch()['Age'];
$joueurMAX = $bdd->query("SELECT j.nom AS nom FROM joueur j, marquer_but b WHERE j.idj = b.idj AND b.nbr_but = (SELECT MAX(b2.nbr_but) AS max_but FROM marquer_but b2)");
$joueur = $joueurMAX->fetch()['nom'];
while ($donnees = $reponse->fetch()) {
    $pdf->Cell(30, 10, $donnees['idj'], 1);
    $pdf->Cell(30, 10, $donnees['Match_joues'], 1);
    $pdf->Cell(30, 10, $donnees['nbr_but'], 1);
    $pdf->Cell(30, 10, $ageMoy, 1);
    $pdf->Cell(30, 10, $joueur, 1);
    $pdf->Ln();}
$pdf->Output();
?>