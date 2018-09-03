<?php

namespace luckyBundle\Controller;

use AppBundle\Form\PhotoType;
use luckyBundle\Entity\Band;
use luckyBundle\Entity\Concert;
use luckyBundle\Entity\Photo;
use luckyBundle\Entity\Song;
use luckyBundle\Entity\Video;
use luckyBundle\Form\BandType;
use luckyBundle\Form\ConcertType;
use luckyBundle\Form\SongType;
use luckyBundle\Form\VideoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getdoctrine()->getRepository(Concert::class); //Je récupère le repo avec lequel je veux travailler en passant par l’entité qui lui est lié
        $concerts = $repository->findAll();
        return $this->render('@lucky/Default/index.html.twig', array(
            'concerts' => $concerts
        ));
    }

    public function dateAction()
    {
        $repository = $this->getdoctrine()->getRepository(Concert::class); //Je récupère le repo avec lequel je veux travailler en passant par l’entité qui lui est lié
        $concerts = $repository->findAll(); //on utilise la methode findall du repository pour récupérer les éléments de la table concernée
        return $this->render('@lucky/Default/dates.html.twig', array(
            'concerts' => $concerts
        ));
    }

    public function bandAction()
    {
        $repository = $this->getdoctrine()->getRepository(Band::class); //Je récupère le repo avec lequel je veux travailler en passant par l’entité qui lui est lié
        $members = $repository->findAll(); //on utilise la methode findall du repository pour récupérer les éléments de la table concernée
        return $this->render('@lucky/Default/band.html.twig', array(
            'members' => $members
        ));
    }

    public function songsAction()
    {
        $repository = $this->getdoctrine()->getRepository(Song::class); //Je récupère le repo avec lequel je veux travailler en passant par l’entité qui lui est lié
        $songs = $repository->findAll(); //on utilise la methode findall du repository pour récupérer les éléments de la table concernée
        return $this->render('@lucky/Default/songs.html.twig', array(
            'songs' => $songs
        ));
    }

    public function lyricsAction($id)
    {
        $repository = $this->getdoctrine()->getRepository(Song::class); //Je récupère le repo avec lequel je veux travailler en passant par l’entité qui lui est lié
        $song = $repository->find($id); //on utilise la methode findall du repository pour récupérer les éléments de la table concernée
        return $this->render('@lucky/Default/song.html.twig', array(
            'song' => $song
        ));
    }


    public function videosAction()
    {
        $repository = $this->getdoctrine()->getRepository(Video::class); //Je récupère le repo avec lequel je veux travailler en passant par l’entité qui lui est lié
        $videos = $repository->findAll(); //on utilise la methode findall du repository pour récupérer les éléments de la table concernée
        return $this->render('@lucky/Default/videos.html.twig', array(
            'videos' => $videos
        ));
    }

    public function photosAction()
    {
        $repository = $this->getdoctrine()->getRepository(\AppBundle\Entity\Photo::class); //Je récupère le repo avec lequel je veux travailler en passant par l’entité qui lui est lié
        $photos = $repository->findAll(); //on utilise la methode findall du repository pour récupérer les éléments de la table concernée
        return $this->render('@lucky/Default/photos.html.twig', array(
            'photos' => $photos
        ));
    }

//*******************************//
//************ ADMIN ************//
//*******************************//

    public function adminAction()  // admin homepage
    {
        return $this->render('@lucky/Default/formAdmin/admin.html.twig');
    }


//******add_forms******//

    public function addSongAction(Request $request)
    {
        $song = new Song();

        $form = $this->createForm(SongType::class, $song);
        $formview = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($song);
            $em->flush();
        }
        return $this->render('@lucky/Default/formAdmin/addForms/addSong.html.twig', array(
            'formView' => $formview
        ));
    }

    public function addDateAction(Request $request)
    {
        $concert = new Concert();

        $form = $this->createForm(ConcertType::class, $concert);
        $formview = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($concert);
            $em->flush();
        }
        return $this->render('@lucky/Default/formAdmin/addForms/addDate.html.twig', array(
            'formView' => $formview
        ));
    }

    public function addMemberAction(Request $request)
    {
        $band = new Band();

        $form = $this->createForm(BandType::class, $band);
        $formview = $form->createView();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($band);
            $em->flush();
        }
        return $this->render('@lucky/Default/formAdmin/addForms/addMember.html.twig', array(
            'formView' => $formview
        ));
    }

    public function addPhotoAction(Request $request)
    {
        $photo = new \AppBundle\Entity\Photo();

        $form = $this->createForm(PhotoType::class, $photo);
        $formview = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
        }
        return $this->render('@lucky/Default/formAdmin/addForms/addPhoto.html.twig', array(
            'formView' => $formview
        ));
    }

    public function addVideoAction(Request $request)
    {
        $video = new Video();

        $form = $this->createForm(VideoType::class, $video);
        $formview = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();
        }
        return $this->render('@lucky/Default/formAdmin/addForms/addVideo.html.twig', array(
            'formView' => $formview
        ));
    }



//******delete actions******//
    public function deletePhotoAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(\AppBundle\Entity\Photo::class);
        $photo = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);

        $em->flush();

        return $this->redirectToRoute('lucky_photos');
    }

    public function deleteSongAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(Song::class);
        $song = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($song);

        $em->flush();

        return $this->redirectToRoute('lucky_songs');
    }

    public function deleteDateAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(Concert::class);
        $concert = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($concert);

        $em->flush();

        return $this->redirectToRoute('lucky_date');
    }

    public function deleteMemberAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(Band::class);
        $band = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($band);

        $em->flush();

        return $this->redirectToRoute('lucky_band');
    }

    public function deleteVideoAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(Video::class);
        $video = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($video);

        $em->flush();

        return $this->redirectToRoute('lucky_videos');
    }

//******update actions******//
    public function updateSongAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Song::class);
        $song = $repository->find($id);

        $form = $this->createForm(SongType::class, $song);
        $formView = $form->createView();
        $form->handleRequest($request);  //Je relie mon formulaire a la requête http

        if ($form->IsSubmitted() && $form->isValid()) {
            $song = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($song);
            $em->flush();

            return $this->redirectToRoute('lucky_songs');
        }

        return $this->render('@lucky/Default/formAdmin/updateForms/updateSong.html.twig', array(
            'formView' => $formView,
            'song' => $song
        ));
    }

    public function updateDateAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Concert::class);
        $concert = $repository->find($id);

        $form = $this->createForm(ConcertType::class, $concert);
        $formView = $form->createView();
        $form->handleRequest($request);  //Je relie mon formulaire a la requête http

        if ($form->IsSubmitted() && $form->isValid()) {
            $concert = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($concert);
            $em->flush();

            return $this->redirectToRoute('lucky_date');
        }

        return $this->render('@lucky/Default/formAdmin/updateForms/updateDate.html.twig', array(
            'formView' => $formView,
            'concert' => $concert
        ));
    }

    public function updateMemberAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Band::class);
        $band = $repository->find($id);

        $form = $this->createForm(BandType::class, $band);
        $formView = $form->createView();
        $form->handleRequest($request);  //Je relie mon formulaire a la requête http

        if ($form->IsSubmitted() && $form->isValid()) {
            $band = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($band);
            $em->flush();

            return $this->redirectToRoute('lucky_band');
        }

        return $this->render('@lucky/Default/formAdmin/updateForms/updateMember.html.twig', array(
            'formView' => $formView,
            'band' => $band
        ));
    }

}
