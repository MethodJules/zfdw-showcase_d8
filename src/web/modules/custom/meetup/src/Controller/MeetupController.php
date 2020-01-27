<?php

namespace Drupal\meetup\Controller;

use Exception;

class MeetupController {
    public function content() {
        return ['#markup' => 'Content'];
    }

    public function insertUserIsInterested($event_id) {
        $uid = \Drupal::currentUser()->id();
        $nid = $event_id;
        //Save the value to the database
        try {
          \Drupal::database()->insert('xnavi_meetup')
            ->fields([
              'uid',
              'nid',
              'interested',
              'participate',
            ])
          ->values([
            $uid,
            $nid,
            'yes',
            'no',
          ])
          ->execute();
          \Drupal::messenger()->addMessage('Ihr Interesse wurde gespeichert.');

        } catch(\Exception $e) {
          \Drupal::logger('type')->error($e->getMessage());
        }
        //Show message that the event was saved
        return ['#markup' => 'Event ' . $event_id . ' for User ' . $uid . ' saved...'];
    }

    public function updateUserIsInterested($event_id) {
        $uid = \Drupal::currentUser()->id();
        $nid = $event_id;

        //Get data
        try {
            $database = \Drupal::database();
            $query = $database->select('xnavi_meetup', 'xm')
                ->fields('xm',['interested'])
                ->condition('xm.uid', $uid)
                ->condition('xm.nid', $nid);
            $result = $query->execute();
        } catch (Exception $e) {
            \Drupal::logger('type')->error($e->getMessage());
        }

        foreach($result as $record) {
            ksm($record->interested);
            try {
                if($record->interested === 'yes') {
                    $flag = 'no';
                } else {
                    $flag = 'yes';
                }
                $query = $database->update('xnavi_meetup')
                    ->fields(['interested' => $flag])
                    ->condition('uid', $uid, '=')
                    ->condition('nid', $nid, '=');
                $query->execute();
            } catch (Exception $e) {
                \Drupal::logger('type')->error($e->getMessage());
            }
        }

        return  ['#markup' => 'Update'];
    }

    public function insertUserIsParticipating($event_id) {
        $uid = \Drupal::currentUser()->id();
        $nid = $event_id;

        try {
          \Drupal::database()->insert('xnavi_meetup')
            ->fields([
              'uid',
              'nid',
              'interested',
              'participate',
            ])
            ->values([
              $uid,
              $nid,
              'yes',
              'yes',
            ])
            ->execute();
          \Drupal::messenger()->addMessage('Ihre Teilnahme wurde gespeichert.');

        } catch(\Exception $e) {
          \Drupal::logger('type')->error($e->getMessage());
        }


        return ['#markup' => 'Event ' . $event_id . ' for User ' . $uid . ' saved...'];
    }


}