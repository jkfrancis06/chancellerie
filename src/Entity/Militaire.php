<?php

namespace App\Entity;

use App\Repository\MilitaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MilitaireRepository::class)
 *
 */
class Militaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenoms;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="float")
     */
    private $taille;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleurYeux;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $situationMatri;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="date")
     */
    private $dateIncorp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $professionAnt;

    /**
     * @ORM\OneToMany(targetEntity=Fichier::class, mappedBy="militaire", cascade={"persist", "remove"})
     */
    private $fichiers;

    /**
     * @ORM\OneToMany(targetEntity=Telephone::class, mappedBy="militaire", orphanRemoval=true,cascade={"persist"})
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Grade::class, inversedBy="militaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grade;

    /**
     * @ORM\ManyToOne(targetEntity=Specialite::class, inversedBy="militaires")
     * @ORM\JoinColumn(nullable=true)
     */
    private $specialite;

    /**
     * @ORM\ManyToOne(targetEntity=OrigineRecrutement::class, inversedBy="militaires")
     * @ORM\JoinColumn(nullable=true)
     */
    private $origineRecrutement;

    /**
     * @ORM\OneToOne(targetEntity=Logement::class, inversedBy="militaire", cascade={"persist", "remove"})
     */
    private $logement;

    /**
     * @ORM\OneToMany(targetEntity=Affectation::class, mappedBy="militaire",cascade={"persist", "remove"})
     */
    private $affectations;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireFonction::class, mappedBy="militaire", orphanRemoval=true)
     */
    private $militaireFonctions;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireStatut::class, mappedBy="militaire", cascade={"persist", "remove"})
     */
    private $militaireStatuts;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireMission::class, mappedBy="militaire", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $militaireMissions;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireMedaille::class, mappedBy="militaire", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $militaireMedailles;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireDiplome::class, mappedBy="militaire", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $militaireDiplomes;

    /**
     * @ORM\OneToMany(targetEntity=MilitaireFormation::class, mappedBy="militaire", cascade={"persist", "remove"})
     */
    private $militaireFormations;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasChildren;


    /**
     * @ORM\OneToMany(targetEntity=MilitaireExercice::class, mappedBy="militaire", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $militaireExercices;

    /**
     * @ORM\OneToMany(targetEntity=Famille::class, mappedBy="militaire", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $familles;

    /**
     * @ORM\OneToMany(targetEntity=Unite::class, mappedBy="chefFormation")
     */
    private $formationDirected;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
        private $groupeSanguin;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $mainPicture;

        /**
         * @ORM\OneToMany(targetEntity=MilitaireSpa::class, mappedBy="militaire", orphanRemoval=true)
         */
        private $militaireSpas;

        /**
         * @ORM\OneToMany(targetEntity=Spa::class, mappedBy="createdBy")
         */
        private $spas;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $surnom;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $quartier;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $numCarte;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $numPassport;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $permisConduireCiv;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $permisConduireMil;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $nivInstruGen;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $formTech;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $languePar;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $langueEcr;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $sports;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $lieuNaissance;

        /**
         * @ORM\OneToMany(targetEntity=CompteBanqMilitaire::class, mappedBy="militaire", cascade={"persist", "remove"})
         */
        private $compteBanqMilitaires;

        /**
         * @ORM\OneToOne(targetEntity=PersonnePrev::class, mappedBy="militaire", cascade={"persist", "remove"})
         */
        private $personnePrev;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $lieuPermission;

        /**
         * @ORM\OneToMany(targetEntity=SousDossier::class, mappedBy="militaire", cascade={"persist", "remove"})
         */
        private $sousDossiers;

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
        $this->telephone = new ArrayCollection();
        $this->affectations = new ArrayCollection();
        $this->militaireFonctions = new ArrayCollection();
        $this->militaireStatuts = new ArrayCollection();
        $this->militaireMissions = new ArrayCollection();
        $this->militaireMedailles = new ArrayCollection();
        $this->militaireDiplomes = new ArrayCollection();
        $this->militaireFormations = new ArrayCollection();
        $this->militaireExercices = new ArrayCollection();
        $this->familles = new ArrayCollection();
        $this->formationDirected = new ArrayCollection();
        $this->militaireSpas = new ArrayCollection();
        $this->spas = new ArrayCollection();
        $this->compteBanqMilitaires = new ArrayCollection();
        $this->sousDossiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTaille(): ?float
    {
        return $this->taille;
    }

    public function setTaille(float $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getCouleurYeux(): ?string
    {
        return $this->couleurYeux;
    }

    public function setCouleurYeux(?string $couleurYeux): self
    {
        $this->couleurYeux = $couleurYeux;

        return $this;
    }

    public function getSituationMatri(): ?string
    {
        return $this->situationMatri;
    }

    public function setSituationMatri(string $situationMatri): self
    {
        $this->situationMatri = $situationMatri;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDateIncorp(): ?\DateTimeInterface
    {
        return $this->dateIncorp;
    }

    public function setDateIncorp(\DateTimeInterface $dateIncorp): self
    {
        $this->dateIncorp = $dateIncorp;

        return $this;
    }

    public function getProfessionAnt(): ?string
    {
        return $this->professionAnt;
    }

    public function setProfessionAnt(string $professionAnt): self
    {
        $this->professionAnt = $professionAnt;

        return $this;
    }

    /**
     * @return Collection|Fichier[]
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setMilitaire($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getMilitaire() === $this) {
                $fichier->setMilitaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Telephone[]
     */
    public function getTelephone(): Collection
    {
        return $this->telephone;
    }

    public function addTelephone(Telephone $telephone): self
    {
        if (!$this->telephone->contains($telephone)) {
            $this->telephone[] = $telephone;
            $telephone->setMilitaire($this);
        }

        return $this;
    }

    public function removeTelephone(Telephone $telephone): self
    {
        if ($this->telephone->removeElement($telephone)) {
            // set the owning side to null (unless already changed)
            if ($telephone->getMilitaire() === $this) {
                $telephone->setMilitaire(null);
            }
        }

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getOrigineRecrutement(): ?OrigineRecrutement
    {
        return $this->origineRecrutement;
    }

    public function setOrigineRecrutement(?OrigineRecrutement $origineRecrutement): self
    {
        $this->origineRecrutement = $origineRecrutement;

        return $this;
    }

    public function getLogement(): ?Logement
    {
        return $this->logement;
    }

    public function setLogement(?Logement $logement): self
    {
        $this->logement = $logement;

        return $this;
    }

    /**
     * @return Collection|Affectation[]
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->setMilitaire($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->removeElement($affectation)) {
            // set the owning side to null (unless already changed)
            if ($affectation->getMilitaire() === $this) {
                $affectation->setMilitaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MilitaireFonction[]
     */
    public function getMilitaireFonctions(): Collection
    {
        return $this->militaireFonctions;
    }

    public function addMilitaireFonction(MilitaireFonction $militaireFonction): self
    {
        if (!$this->militaireFonctions->contains($militaireFonction)) {
            $this->militaireFonctions[] = $militaireFonction;
            $militaireFonction->setMilitaire($this);
        }

        return $this;
    }

    public function removeMilitaireFonction(MilitaireFonction $militaireFonction): self
    {
        if ($this->militaireFonctions->removeElement($militaireFonction)) {
            // set the owning side to null (unless already changed)
            if ($militaireFonction->getMilitaire() === $this) {
                $militaireFonction->setMilitaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MilitaireStatut[]
     */
    public function getMilitaireStatuts(): Collection
    {
        return $this->militaireStatuts;
    }

    public function addMilitaireStatut(MilitaireStatut $militaireStatut): self
    {
        if (!$this->militaireStatuts->contains($militaireStatut)) {
            $this->militaireStatuts[] = $militaireStatut;
            $militaireStatut->setMilitaire($this);
        }

        return $this;
    }

    public function removeMilitaireStatut(MilitaireStatut $militaireStatut): self
    {
        if ($this->militaireStatuts->removeElement($militaireStatut)) {
            // set the owning side to null (unless already changed)
            if ($militaireStatut->getMilitaire() === $this) {
                $militaireStatut->setMilitaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MilitaireMission[]
     */
    public function getMilitaireMissions(): Collection
    {
        return $this->militaireMissions;
    }

    public function addMilitaireMission(MilitaireMission $militaireMission): self
    {
        if (!$this->militaireMissions->contains($militaireMission)) {
            $this->militaireMissions[] = $militaireMission;
            $militaireMission->setMilitaire($this);
        }

        return $this;
    }

    public function removeMilitaireMission(MilitaireMission $militaireMission): self
    {
        if ($this->militaireMissions->removeElement($militaireMission)) {
            // set the owning side to null (unless already changed)
            if ($militaireMission->getMilitaire() === $this) {
                $militaireMission->setMilitaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MilitaireMedaille[]
     */
    public function getMilitaireMedailles(): Collection
    {
        return $this->militaireMedailles;
    }

    public function addMilitaireMedaille(MilitaireMedaille $militaireMedaille): self
    {
        if (!$this->militaireMedailles->contains($militaireMedaille)) {
            $this->militaireMedailles[] = $militaireMedaille;
            $militaireMedaille->setMilitaire($this);
        }

        return $this;
    }

    public function removeMilitaireMedaille(MilitaireMedaille $militaireMedaille): self
    {
        if ($this->militaireMedailles->removeElement($militaireMedaille)) {
            // set the owning side to null (unless already changed)
            if ($militaireMedaille->getMilitaire() === $this) {
                $militaireMedaille->setMilitaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MilitaireDiplome[]
     */
    public function getMilitaireDiplomes(): Collection
    {
        return $this->militaireDiplomes;
    }

    public function addMilitaireDiplome(MilitaireDiplome $militaireDiplome): self
    {
        if (!$this->militaireDiplomes->contains($militaireDiplome)) {
            $this->militaireDiplomes[] = $militaireDiplome;
            $militaireDiplome->setMilitaire($this);
        }

        return $this;
    }

    public function removeMilitaireDiplome(MilitaireDiplome $militaireDiplome): self
    {
        if ($this->militaireDiplomes->removeElement($militaireDiplome)) {
            // set the owning side to null (unless already changed)
            if ($militaireDiplome->getMilitaire() === $this) {
                $militaireDiplome->setMilitaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MilitaireFormation[]
     */
    public function getMilitaireFormations(): Collection
    {
        return $this->militaireFormations;
    }

    public function addMilitaireFormation(MilitaireFormation $militaireFormation): self
    {
        if (!$this->militaireFormations->contains($militaireFormation)) {
            $this->militaireFormations[] = $militaireFormation;
            $militaireFormation->setMilitaire($this);
        }

        return $this;
    }

    public function removeMilitaireFormation(MilitaireFormation $militaireFormation): self
    {
        if ($this->militaireFormations->removeElement($militaireFormation)) {
            // set the owning side to null (unless already changed)
            if ($militaireFormation->getMilitaire() === $this) {
                $militaireFormation->setMilitaire(null);
            }
        }

        return $this;
    }


    public function getHasChildren(): ?bool
    {
        return $this->hasChildren;
    }

    public function setHasChildren(bool $hasChildren): self
    {
        $this->hasChildren = $hasChildren;

        return $this;
    }


    /**
     * @return Collection|MilitaireExercice[]
     */
    public function getMilitaireExercices(): Collection
    {
        return $this->militaireExercices;
    }

    public function addMilitaireExercice(MilitaireExercice $militaireExercice): self
    {
        if (!$this->militaireExercices->contains($militaireExercice)) {
            $this->militaireExercices[] = $militaireExercice;
            $militaireExercice->setMilitaire($this);
        }

        return $this;
    }

    public function removeMilitaireExercice(MilitaireExercice $militaireExercice): self
    {
        if ($this->militaireExercices->removeElement($militaireExercice)) {
            // set the owning side to null (unless already changed)
            if ($militaireExercice->getMilitaire() === $this) {
                $militaireExercice->setMilitaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Famille[]
     */
    public function getFamilles(): Collection
    {
        return $this->familles;
    }

    public function addFamille(Famille $famille): self
    {
        if (!$this->familles->contains($famille)) {
            $this->familles[] = $famille;
            $famille->setMilitaire($this);
        }

        return $this;
    }

    public function removeFamille(Famille $famille): self
    {
        if ($this->familles->removeElement($famille)) {
            // set the owning side to null (unless already changed)
            if ($famille->getMilitaire() === $this) {
                $famille->setMilitaire(null);
            }
        }

        return $this;
    }


    public function addDate($interval){
        $timestamp = $this->dateNaissance->getTimestamp();

        return strtotime('+'.$interval.' year', $timestamp);
    }

    /**
     * @return Collection|Unite[]
     */
    public function getFormationDirected(): Collection
    {
        return $this->formationDirected;
    }

    public function addFormationDirected(Unite $formationDirected): self
    {
        if (!$this->formationDirected->contains($formationDirected)) {
            $this->formationDirected[] = $formationDirected;
            $formationDirected->setChefFormation($this);
        }

        return $this;
    }

    public function removeFormationDirected(Unite $formationDirected): self
    {
        if ($this->formationDirected->removeElement($formationDirected)) {
            // set the owning side to null (unless already changed)
            if ($formationDirected->getChefFormation() === $this) {
                $formationDirected->setChefFormation(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->getMatricule().' - '.$this->getNom().' '.$this->getPrenoms();
    }

    public function getGroupeSanguin(): ?string
    {
        return $this->groupeSanguin;
    }

    public function setGroupeSanguin(?string $groupeSanguin): self
    {
        $this->groupeSanguin = $groupeSanguin;

        return $this;
    }

    public function getMainPicture(): ?string
    {
        return $this->mainPicture;
    }

    public function setMainPicture(?string $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }

    /**
     * @return Collection|MilitaireSpa[]
     */
    public function getMilitaireSpas(): Collection
    {
        return $this->militaireSpas;
    }

    public function addMilitaireSpa(MilitaireSpa $militaireSpa): self
    {
        if (!$this->militaireSpas->contains($militaireSpa)) {
            $this->militaireSpas[] = $militaireSpa;
            $militaireSpa->setMilitaire($this);
        }

        return $this;
    }

    public function removeMilitaireSpa(MilitaireSpa $militaireSpa): self
    {
        if ($this->militaireSpas->removeElement($militaireSpa)) {
            // set the owning side to null (unless already changed)
            if ($militaireSpa->getMilitaire() === $this) {
                $militaireSpa->setMilitaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Spa[]
     */
    public function getSpas(): Collection
    {
        return $this->spas;
    }

    public function addSpa(Spa $spa): self
    {
        if (!$this->spas->contains($spa)) {
            $this->spas[] = $spa;
            $spa->setCreatedBy($this);
        }

        return $this;
    }

    public function removeSpa(Spa $spa): self
    {
        if ($this->spas->removeElement($spa)) {
            // set the owning side to null (unless already changed)
            if ($spa->getCreatedBy() === $this) {
                $spa->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function getSurnom(): ?string
    {
        return $this->surnom;
    }

    public function setSurnom(?string $surnom): self
    {
        $this->surnom = $surnom;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(?string $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getNumCarte(): ?string
    {
        return $this->numCarte;
    }

    public function setNumCarte(?string $numCarte): self
    {
        $this->numCarte = $numCarte;

        return $this;
    }

    public function getNumPassport(): ?string
    {
        return $this->numPassport;
    }

    public function setNumPassport(?string $numPassport): self
    {
        $this->numPassport = $numPassport;

        return $this;
    }

    public function getPermisConduireCiv(): ?string
    {
        return $this->permisConduireCiv;
    }

    public function setPermisConduireCiv(?string $permisConduireCiv): self
    {
        $this->permisConduireCiv = $permisConduireCiv;

        return $this;
    }

    public function getPermisConduireMil(): ?string
    {
        return $this->permisConduireMil;
    }

    public function setPermisConduireMil(?string $permisConduireMil): self
    {
        $this->permisConduireMil = $permisConduireMil;

        return $this;
    }

    public function getNivInstruGen(): ?string
    {
        return $this->nivInstruGen;
    }

    public function setNivInstruGen(?string $nivInstruGen): self
    {
        $this->nivInstruGen = $nivInstruGen;

        return $this;
    }

    public function getFormTech(): ?string
    {
        return $this->formTech;
    }

    public function setFormTech(?string $formTech): self
    {
        $this->formTech = $formTech;

        return $this;
    }

    public function getLanguePar(): ?string
    {
        return $this->languePar;
    }

    public function setLanguePar(?string $languePar): self
    {
        $this->languePar = $languePar;

        return $this;
    }

    public function getLangueEcr(): ?string
    {
        return $this->langueEcr;
    }

    public function setLangueEcr(?string $langueEcr): self
    {
        $this->langueEcr = $langueEcr;

        return $this;
    }

    public function getSports(): ?string
    {
        return $this->sports;
    }

    public function setSports(?string $sports): self
    {
        $this->sports = $sports;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    /**
     * @return Collection|CompteBanqMilitaire[]
     */
    public function getCompteBanqMilitaires(): Collection
    {
        return $this->compteBanqMilitaires;
    }

    public function addCompteBanqMilitaire(CompteBanqMilitaire $compteBanqMilitaire): self
    {
        if (!$this->compteBanqMilitaires->contains($compteBanqMilitaire)) {
            $this->compteBanqMilitaires[] = $compteBanqMilitaire;
            $compteBanqMilitaire->setMilitaire($this);
        }

        return $this;
    }

    public function removeCompteBanqMilitaire(CompteBanqMilitaire $compteBanqMilitaire): self
    {
        if ($this->compteBanqMilitaires->removeElement($compteBanqMilitaire)) {
            // set the owning side to null (unless already changed)
            if ($compteBanqMilitaire->getMilitaire() === $this) {
                $compteBanqMilitaire->setMilitaire(null);
            }
        }

        return $this;
    }

    public function getPersonnePrev(): ?PersonnePrev
    {
        return $this->personnePrev;
    }

    public function setPersonnePrev(PersonnePrev $personnePrev): self
    {
        // set the owning side of the relation if necessary
        if ($personnePrev->getMilitaire() !== $this) {
            $personnePrev->setMilitaire($this);
        }

        $this->personnePrev = $personnePrev;

        return $this;
    }

    public function getLieuPermission(): ?string
    {
        return $this->lieuPermission;
    }

    public function setLieuPermission(?string $lieuPermission): self
    {
        $this->lieuPermission = $lieuPermission;

        return $this;
    }

    /**
     * @return Collection|SousDossier[]
     */
    public function getSousDossiers(): Collection
    {
        return $this->sousDossiers;
    }

    public function addSousDossier(SousDossier $sousDossier): self
    {
        if (!$this->sousDossiers->contains($sousDossier)) {
            $this->sousDossiers[] = $sousDossier;
            $sousDossier->setMilitaire($this);
        }

        return $this;
    }

    public function removeSousDossier(SousDossier $sousDossier): self
    {
        if ($this->sousDossiers->removeElement($sousDossier)) {
            // set the owning side to null (unless already changed)
            if ($sousDossier->getMilitaire() === $this) {
                $sousDossier->setMilitaire(null);
            }
        }

        return $this;
    }



}
