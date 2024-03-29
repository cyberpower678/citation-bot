#!/usr/bin/php
<?php
// $Id$
#$abort_mysql_connection = true; // Whilst there's a problem with login

$account_suffix = '_4'; // Keep this before including expandFns
error_reporting(E_ALL^E_NOTICE);
$slow_mode = 1;
$slow_mode = ($argument["slow"] || $argument["slowmode"] || $argument["thorough"]) ? true : false;
include('expandFns.php');

$bot_exclusion_compliant = TRUE;

$problem_text =  <<<problemtxt

#todo


problemtxt;

$page = new Page();
$page->text =  <<<problemtxt

{{cite journal |last1=Allende |first1=Luise M. |last2=Rubio |first2=Isabel |last3=Ruiz del Valle |first3=Valentin |last4=Guill�n |first4=Jesus |last5=Mart�nez-Laso |first5=Jorge |last6=Lowy |first6=Ernesto |last7=Varela |first7=Pilar |last8=Zamora |first8=Jorge |last9=Arnaiz-Villena |first9=Antonio |year=2001 | title= The Old World sparrows (genus ''Passer'') phylogeography and their relative abundance of nuclear mtDNA pseudogenes | journal= [[Journal of Molecular Evolution]] | volume=53| pmid= 11479685 | pages= 144�154| url = http://chopo.pntic.mec.es/~biolmol/publicaciones/Passer.pdf |format = PDF| issue= 2|archiveurl=http://web.archive.org/web/20110721034443/http://chopo.pntic.mec.es/~biolmol/publicaciones/Passer.pdf|archivedate=21 July 2011 | doi=<!-- do not add unless it works -->}}</

problemtxt;

#$page->get_text_from('Amyotrophic_lateral_sclerosis');
print "\n\n";
$page->expand_text();
die($page->text .  "\n \n" . $page->edit_summary() . "\n\n");

if ($page->get_text_from('User:DOI_bot/Zandbox') && $page->expand_text()) {
  echo "\n # Writing to " . $page->title . ' with edit summary ' . $page->edit_summary() . "\n";
  print $page->text; die("\n\nbyebye\n");
  while (!$page->write() && $attempts < 2) ++$attempts;
  if ($attempts < 3 ) echo $html_output ?
       " <small><a href=https://en.wikipedia.org/w/index.php?title=" . urlencode($page) . "&action=history>history</a> / "
       . "<a href=https://en.wikipedia.org/w/index.php?title=" . urlencode($page) . "&diff=prev&oldid="
       . getLastRev($page) . ">last edit</a></small></i>\n\n<br>"
       : ".";
  else echo "\n # Failed. \n" . $page->text;
} else {
  echo "\n # " . ($page->text ? 'No changes required.' : 'Blank page') . "\n # # # ";
  updateBacklog($page->title);
}

    
    die("\n# # # \n");
    





foreach ($argv as $arg) {
  if (substr($arg, 0, 2) == "--") {
    $argument[substr($arg, 2)] = 1;
  } elseif (substr($arg, 0, 1) == "-") {
    $oArg = substr($arg, 1);
  } else {
    switch ($oArg) {
      case "P": case "A": case "T":
        $argument["pages"][] = $arg;
        break;
      default:
      $argument[$oArg][] = $arg;
    }
  }
}

$account_suffix = '_' . ($argument['user'] ? $argument['user'][0] : '1'); // Keep this before including expandFns
include("object_expandFns.php");
$htmlOutput = false;
$editInitiator = '[Pu' . (revisionID() + 1) . '&beta;]';
define ("START_HOUR", date("H"));

function nextPage($page){
  // touch last page
  if ($page) {
    touch_page($page);
  }

  // Get next page
  global $ON, $STOP;
	if (!$ON || $STOP) die ("\n** EXIT: Bot switched off.\n");
  if (date("H") != START_HOUR) die ("\n ** EXIT: It's " . date("H") . " o'clock!\n");
	$db = udbconnect("yarrow");
	$result = mysql_query ("SELECT /* SLOW_OK */ page FROM citation ORDER BY fast ASC") or die(mysql_error());
	$result = mysql_query("SELECT /* SLOW_OK */ page FROM citation ORDER BY fast ASC") or die (mysql_error());
	$result = mysql_fetch_row($result);
  mysql_close($db);
	return $result[0];
}
$ON = $argument["on"];


if ($argument["pages"]) {
  foreach ($argument["pages"] as $page) {
    expand($page, $ON);
  }
} elseif ($argument["sandbox"] || $argument["sand"]) {
  expand("User:DOI bot/Zandbox", $ON);
} else {
   if ($ON) {
    echo "\n Fetching first page from backlog ... ";
    $page = nextPage($page);
    echo " done. ";
  } else {
   

      $slow_mode = true;
    die (expand_text(
            $problem_text, false, false
));
    
die(expand_text("
  More title tampering
{cite journal |author=Fazilleau et al. |title=Follicular helper T cells: lineage and location |journal=Immunity |volume=30 |issue=3 |pages=324�35 |year=2009 |month=March |pmid=19303387 |doi=10.1016/j.immuni.2009.03.003 
|last2=Mark |first2=L |last3=McHeyzer-Williams |first3=LJ |last4=McHeyzer-Williams |first4=MG |pmc=2731675}}</ref>.
"));

die (expand_text('

Reference renaming:

{{ref doi|10.1016/S0016-6995(97)80056-3}}

.<ref name="Wilby1997">{{cite doi|10.1016/S0016-6995(97)80056-3 }}</ref>


'));
    
/*/
// For version 3:
die (expand_text("

{{cite journal | author = Ridzon R, Gallagher K, Ciesielski C ''et al.'' | year = 1997 | title = Simultaneous transmission of human immunodeficiency virus and hepatitis C virus from a needle-stick injury | url = | journal = N Engl J Med | volume = 336 | issue = | pages = 919�22 }}. (full stop to innards)<
<ref>http://www.ncbi.nlm.nih.gov/pubmed/15361495</ref>
", false));
/**/
  }
  /*$start_code = getRawWikiText($page, false, false);*/
  $slow_mode = true;

  print "\n";
  //
  
  while ($page) {
    $page = nextPage($page);
    $end_text = expand($page, $ON);
  }
  //write($page, $end_text, $editInitiator . "Re task #6 : Trial edit");
}
die ("\n Done. \n");