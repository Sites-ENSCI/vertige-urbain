<HTML lang="fr">
<?php include "./meta_header.html";?>
  <body class="body">
    <div class="entete" id="debut">
      <div class="colonne_1">
        <p class="entete"><a href="vertige-urbain.php" class="entete"><B>Vertige urbain</B> - Mémoire de fin d'études</a></p>
      </div>
      <div class="colonne_2">
        <p class="entete"><a href="../index.php"><img src="../img/symbole-lecture-blanc-lecture-et-texte.svg" alt="Vidéothèque" class="entete"></a></p>
      </div>
      <div class="colonne_3">
        <p class="entete"><B>Betty LUJAN</B> - ENSCI Les Ateliers 2020</p>
      </div>
    </div>
    <div class="corps">
      <div class="grille">
        <div class="entete_grille" id="haut">
          <p class="txt_entete_grille"><I>Explorer</I></p>
          <a href="./DansLeMemoire_auto.php" class="txt_entete_grille"><I>Dans le mémoire</I></a>
        </div>
        <!-- début du code généré par PHP automatique -->
        <?php

          error_reporting(0); // ne rapporte aucune erreur -> version exploitation
          //error_reporting(E_ALL);// rapporte toutes les erreurs -> version dev

          $fd = fopen("../img/Data_Explorer.txt", "r");//ouverture du fichier de données en lecture seul
          $ligne_courante = '';
          $nom_fichier_img = '';
          $dimension_img = '';
          $lieu = '';
          $date = '';
          $lien_video = '';
          $code_video = '';
          $num_colonne = 0;
          $num_ligne = 0;
          $compteur_positions_max = 0;
          $compteur_donnees = 0;
          $style = 'style="opacity:1"';
          $mois = array('janvier'   => '01',
                        'fécrier'   => '02',
                        'mars'      => '03',
                        'avril'     => '04',
                        'mai'       => '05',
                        'juin'      => '06',
                        'juillet'   => '07',
                        'août'      => '08',
                        'septembre' => '09',
                        'octobre'   => '10',
                        'novembre'  => '11',
                        'décembre'  => '12',
                       );

          if (!$fd)// test si le fichier est bien ouvert
          {
            echo "pb fichier";
          }
          else// si c'est le cas...
          {
            while (!feof($fd))//tant que ce n'est as la fin du fichier...
            {
              if (!feof($fd))
              {
                $ligne_courante = fgets($fd);//récupère une ligne du fichier.

                  $data = explode("|", $ligne_courante);

                  $compteur_donnees++;

                  $nom_fichier_img = $data[0];
                  $dimension_img = $data[1];
                  $lieu = $data[2];
                  $date = $data[3];
                  $lien_video = $data[4];
                  $code_video = $data[5];
                  $num_colonne = intval($data[6], 10);
                  $num_ligne = intval($data[7], 10);

                  unset($data);

                  $donnees[$nom_fichier_img] = array( 'dimension_img' => $dimension_img,
                                                      'lieu' => $lieu,
                                                      'date' => $date,
                                                      'lien_video' => $lien_video,
                                                      'code_video' => $code_video,
                                                      'num_colonne' => $num_colonne,
                                                      'num_ligne' => $num_ligne
                                                    );

                  if ($donnees[$nom_fichier_img]['num_ligne']>$compteur_positions_max)
                  {
                    $compteur_positions_max = $donnees[$nom_fichier_img]['num_ligne'];
                  }

                  $position[$donnees[$nom_fichier_img]['num_ligne']][$donnees[$nom_fichier_img]['num_colonne']] = $nom_fichier_img;

                  for ($i2=1; $i2 < 8; $i2++)
                  {
                    if (!array_key_exists($i2, $position[$donnees[$nom_fichier_img]['num_ligne']]))
                    {
                      $position[$donnees[$nom_fichier_img]['num_ligne']][$i2] = '';
                    }
                  }

                  ksort($position[$donnees[$nom_fichier_img]['num_ligne']]);

                }
              }

              for ($i=1; $i < $compteur_positions_max+3; $i++)
              {
                if (!array_key_exists($i, $position))
                {
                  $position[$i] = array(1 => '', '', '', '', '', '', '');
                }
              }

              ksort($position);

              for ($i=1; $i < $compteur_positions_max+3; $i++)
              {
                echo '       <!-- Ligne numéro ' . $i . ' -->' . "\n";
                echo "       <div class=\"ligne\">\n";

                for ($i2=1; $i2 < 8; $i2++)
                {
                  echo '          <!-- Colonne numéro ' . $i2 . ' -->' . "\n";
                  if ($position[$i][$i2] != '')
                  {
                    if (isset($_GET['video']))
                    {
                      if (array_key_exists($_GET['video'], $donnees))
                      {
                        if ($position[$i][$i2] == $_GET['video'])
                        {
                          $style = 'style="opacity:0.35"';
                        }
                        else
                        {
                          $style = '';
                        }
                      }
                      else
                      {
                        $style = '';
                      }
                    }
                    else
                    {
                      $style = '';
                    }

                    $data = explode(", ", $donnees[$position[$i][$i2]]['lieu']);
                    $data2 = explode(" ", $donnees[$position[$i][$i2]]['date']);

                    echo "          <div class=\"colonne\"\n";
                    echo '            <figure class="contenu_grille_' . $donnees[$position[$i][$i2]]['dimension_img'] . '" id="' . $position[$i][$i2] . '">' . "\n";
                    echo '              <a href="?video=' . $position[$i][$i2] . '#' . $position[$i][$i2] . '" class="contenu_grille">' . "\n";
                    echo '                <img class="contenu_grille_' . $donnees[$position[$i][$i2]]['dimension_img'] . '" src="../img/blue_betty.jpg" style="opacity:1;position:absolute;top:0;left:0;z-index:0">' . "\n";
                    echo '                <img class="contenu_grille_' . $donnees[$position[$i][$i2]]['dimension_img'] . '" src="../img/Vignettes/' . $position[$i][$i2] . '" ' . $style . '>' . "\n";
                    echo "              </a>\n";
                    //echo '              <figcaption class="contenu_grille_' . $donnees[$position[$i][$i2]]['dimension_img'] . '">' . $data[0] . ' ' . $data2[0] . '.' . $mois[$data2[1]] . '.' . $data2[2] . '.' . $data2[3] . '</figcaption>' . "\n";
                    echo "            </figure>\n";
                    echo "          </div>\n";

                    unset($data);
                    unset($data2);
                  }
                  else
                  {
                    echo "          <div class=\"colonne\"\n";
                    echo "            <p></p>\n";
                    echo "          </div>\n";
                  }
                }
                echo "        </div>\n";
              }
          }

          echo "      </div>\n";
          echo "      <!-- Affichage du player -->\n      <div class=\"player\">\n";
          echo "        <div class=\"contenu\">\n";

          if (isset($_GET['video']))
          {
            if (array_key_exists($_GET['video'], $donnees))
            {
              $data = explode(", ", $donnees[$_GET['video']]['lieu']);

              echo '          ' . $donnees[$_GET['video']]['code_video'] . "\n";
              echo "          </div>\n";
              echo '          <div id="player_legende">' . "\n";
              echo '            <p id="player_legende"><B>' . $data[0] . '</B>' . ', '. $data[1] . '<br />' . $donnees[$_GET['video']]['date'] . "</p>\n";

              unset($data);
            }
            else
            {
              $data = explode(", ", $donnees['Ourguentch_11-01-19_12-39.jpg']['lieu']);

              echo '          ' . $donnees['Ourguentch_11-01-19_12-39.jpg']['code_video'] . "\n";
              echo "          </div>\n";
              echo '          <div id="player_legende">' . "\n";
              echo '            <p id="player_legende"><B>' . $data[0] . '</B>' . ', '. $data[1] . '<br />' . $donnees['Boukhara_14-01-19_10-30.jpg']['date'] . "</p>\n";

              unset($data);
            }
          }
          else
          {
            $data = explode(", ", $donnees['Ourguentch_11-01-19_12-39.jpg']['lieu']);

            echo '          ' . $donnees['Ourguentch_11-01-19_12-39.jpg']['code_video'] . "\n";
            echo "          </div>\n";
            echo '          <div id="player_legende">' . "\n";
            echo '            <p id="player_legende"><B>' . $data[0] . '</B>' . ', '. $data[1] . '<br />' . $donnees['Boukhara_14-01-19_10-30.jpg']['date'] . "</p>\n";

            unset($data);
          }

          echo "          </div>\n";
//          echo '          <div id="retour_haut">' . "\n";
//          echo '            <p style="" id="player_legende">&emsp;<a href="#haut" class="txt_entete_grille" style="font-size: 1em;">&uarr; <span style="font-size: 0.5em;">Top</span></a></p>' . "\n";
//          echo "          </div>\n";
          echo "        </div>\n";
          echo "      </div>\n";
          echo "    </div>\n";
        ?>
      </div>
    </div>
  </body>
</HTML>
