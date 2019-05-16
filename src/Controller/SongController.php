<?php


namespace App\Controller;


//TODO replace business logic

use App\Entity\Song;
use App\Entity\SongDislikes;
use App\Entity\SongLike;
use App\Entity\User;
use App\Form\SongForm;
use App\Repository\SongRepository;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class SongController extends AbstractController
{



    /**
     * @Route ("/add_song", name="addSong")
     * @IsGranted("ROLE_USER")
     */
    public function addSong(Request $request, Security $security)
    {
        $song = new Song();
        $form = $this->createForm(SongForm::class, $song);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $song = $form->getData();
            $song->setOwner($security->getUser());


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($song);
            $entityManager->flush();
            $someNewFilename = $song->getId();
            $songDirectory = 'C:\Users\gabba\php\songs\public\songs';
            $file = $form['file']->getData();
            $file->move($songDirectory, $someNewFilename);

            return $this->redirect($this->generateUrl('mySongs'));
        }

        return $this->render('/songs/addSong.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route ("/song/{id}/delete", name="deleteSong")
     * @IsGranted("ROLE_USER")
     */
    public function deleteSong($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $song = $entityManager->getRepository(Song::class)->find($id);
        $entityManager->remove($song);
        $entityManager->flush();


        return $this->redirectToRoute('mySongs');
    }


    /**
     * @Route ("/my_songs", name="mySongs")
     * @IsGranted("ROLE_USER")
     */
    public function showUserSongs(Request $request, Security $security)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $security->getUser()->getUsername()]);
        if ($request->get('sort') != null) {
            $sort = $request->get('sort');
            if ($sort != 'likesAmount') {
                $songs = $entityManager->getRepository(Song::class)->findBy(array('owner' => $user),
                    array($sort => 'ASC'));
            } else {
                $songs = $entityManager->getRepository(Song::class)->findBy(array('owner' => $user),
                    array($sort => 'DESC'));
            }
        } else {
            $songs = $user->getSongs();
        }
        foreach ($songs as &$song) {
            if ($entityManager->getRepository(SongLike::class)->findOneBy(['song' => $song, 'userLiked' => $user])) {
                $song->setIsUserLiked(true);
            }
            if ($entityManager->getRepository(SongDislikes::class)->findOneBy(['song' => $song, 'userDisliked' => $user])) {
                $song->setIsUserDisliked(true);
            }
        }
        $entityManager->flush();
        return $this->render('/songs/mySongs.html.twig', ['songs' => $songs]);
    }


    /**
     * @Route ("/all_songs", name="allSongs")
     * @IsGranted("ROLE_USER")
     */
    public function showAllSongs(Request $request, Security $security)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $security->getUser()->getUsername()]);
        if ($request->get('sort') != null) {
            $sort = $request->get('sort');
            if ($sort != 'likesAmount') {
                $songs = $entityManager->getRepository(Song::class)->findBy(array(),
                    array($sort => 'ASC'));
            } else {
                $songs = $entityManager->getRepository(Song::class)->findBy(array(),
                    array($sort => 'DESC'));
            }
        } else {
            $songs = $entityManager->getRepository(Song::class)->findAll();
        }
        foreach ($songs as &$song) {
            if ($entityManager->getRepository(SongLike::class)->findOneBy(['song' => $song, 'userLiked' => $user])) {
                $song->setIsUserLiked(true);
            }
            if ($entityManager->getRepository(SongDislikes::class)->findOneBy(['song' => $song, 'userDisliked' => $user])) {
                $song->setIsUserDisliked(true);
            }
        }
        $entityManager->flush();
        return $this->render('/songs/allSongs.html.twig', ['songs' => $songs]);
    }


    /**
     * @Route ("/song/{id}/like", name="likeSong")
     * @IsGranted("ROLE_USER")
     */
    public function likeSong(Request $request, $id, Security $security)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $like = new SongLike();
        $song = $entityManager->getRepository(Song::class)->find($id);
        $like->setSong($song);
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $security->getUser()->getUsername()]);
        $like->setUserLiked($user);
        $entityManager->getRepository(Song::class)->incrementSongLike($song);
        $entityManager->persist($like);
        if ($request->get('dislike') == true) {
            $dislike = $entityManager->getRepository(SongDislikes::class)->findOneBy(['song' => $song, 'userDisliked' => $user]);
            $entityManager->remove($dislike);
            $entityManager->getRepository(Song::class)->decrementSongDislike($song);
        }
        $entityManager->flush();
        return $this->redirect($request->headers->get('referer'));
    }


    /**
     * @Route ("/song/{id}/dislike", name="dislikeSong")
     * @IsGranted("ROLE_USER")
     */
    public function dislikeSong(Request $request, $id, Security $security)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $songDislike = new SongDislikes();
        $song = $entityManager->getRepository(Song::class)->find($id);
        $songDislike->setSong($song);
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $security->getUser()->getUsername()]);
        $songDislike->setUserDisliked($user);
        $entityManager->persist($songDislike);
        if ($request->get('like') == true) {
            $like = $entityManager->getRepository(SongLike::class)->findOneBy(['song' => $song, 'userLiked' => $user]);
            $entityManager->remove($like);
            $entityManager->getRepository(Song::class)->decrementSongLike($song);
        }
        $entityManager->getRepository(Song::class)->incrementSongDislike($song);
        $entityManager->flush();
        return $this->redirect($request->headers->get('referer'));
    }


    /**
     * @Route ("/song/{id}/like/remove", name="removeLike")
     * @IsGranted("ROLE_USER")
     */
    public function removeLike(Request $request, $id, Security $security)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $song = $entityManager->getRepository(Song::class)->find($id);
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $security->getUser()->getUsername()]);

        $like = $entityManager->getRepository(SongLike::class)->findOneBy(['song' => $song, 'userLiked' => $user]);
        $entityManager->remove($like);


        $entityManager->getRepository(Song::class)->decrementSongLike($song);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));

    }


    /**
     * @Route ("/song/{id}/dislike/remove", name="removeDislike")
     * @IsGranted("ROLE_USER")
     */
    public function removeDislike(Request $request, $id, Security $security)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $song = $entityManager->getRepository(Song::class)->find($id);
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $security->getUser()->getUsername()]);
        $dislike = $entityManager->getRepository(SongDislikes::class)->findOneBy(['song' => $song, 'userDisliked' => $user]);
        $entityManager->remove($dislike);
        $entityManager->getRepository(Song::class)->decrementSongDislike($song);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));

    }


}